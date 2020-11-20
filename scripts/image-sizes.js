const fs = require('fs')
const ora = require('ora')
const Json2csvParser = require('json2csv').Parser
const fields = ['location', 'sizes.width', 'sizes.height', 'sizes.retina', 'sizes.ratio']
const dir = {
  conf: './src/conf-img/',
  tpl: './src/conf-img/tpl/',
}
const path = {
  imagesSizesCsv: dir.conf + 'images-sizes.csv',
  imagesSizesJson: dir.conf + 'image-sizes.json',
  imageLocationsJson: dir.conf + 'image-locations.json',
}
const regex = {
  srcset: /data-srcset="(.[^"]*)"/gm,
  crop: /crop="(.[^"]*)"/gm,
  img: /img-\d*-\d*/gm,
}
const locations = {}
const sizes = {}

const isExport = process.argv[2] === 'csv'
let nbLocations = 0
let nbSizes = 0

/**
 * Return an array of names of tpl files
 * @return {array}
 */
function getTemplateFileNames() {
  return fs.readdirSync(dir.tpl).filter(tpl => tpl !== 'default-picture.tpl')
}

/**
 * Return content of tpl file
 * @param {string} templateFileName
 * @return {string}
 */
function getTemplateFileContent(templateFileName) {
  return fs.readFileSync(dir.tpl + templateFileName, 'utf8')
}

/**
 * Create a json file
 * @param {string} destPath
 * @param data
 * @return undefined
 */
function createJsonFile(destPath, data) {
  createFile(destPath, JSON.stringify(data, null, 2))
}

/**
 * Remove extension template name
 * @param {string} name
 * @return {String}
 */
function removeFileExtension(name) {
  return name.split('.')[0]
}

/**
 * Generate default location name based on image size
 * @param {String} size
 * @return {String}
 */
function getDefaultImgName(str) {
  return str.replace('img', 'default') + '.jpg'
}

/**
 * Check if srcset is retina
 * @param {String} src
 * @return {Array}
 */
function isRetina(src) {
  const retina = []
  src.split(',').forEach(val => {
    if (val.includes('2x')) {
      retina.push('2x')
    } else {
      retina.push('')
    }
  })
  return retina
}

/**
 * Create file if he does not exist
 * @param {String} filename
 * @param {String} json
 */
function createFile(filename, json) {
  fs.open(filename, 'r', () => {
    fs.writeFileSync(filename, json)
  })
}

/**
 * Get image locations informations from tpl files
 */
function imageLocationsFromTpl() {
  const templateFileNames = getTemplateFileNames()

  templateFileNames.forEach(tplName => {
    nbLocations += 1
    const tplContent = getTemplateFileContent(tplName)
    const srcsetArr = tplContent.match(regex.srcset)
    const cropArr = tplContent.match(regex.crop)
    const storage = {
      srcsets: [],
      default_img: '',
      img_base: '',
    }

    srcsetArr.forEach(src => {
      const dimensions = src.match(regex.img)
      const retina = isRetina(src)
      const crop = !(cropArr && cropArr[0] === 'crop="false"')

      dimensions.forEach((size, index) => {
        const splitSize = size.split('-')
        const srcsetObj = {
          srcset: retina[index],
          size,
        }

        // TODO: check if size already exists
        if (sizes[size] && sizes[size].crop !== crop) {
          console.log('\nSize already exists but crop is not equal :', size)
        }

        if (!sizes[size]) {
          sizes[size] = {
            width: splitSize[1],
            height: splitSize[2],
            crop: crop,
          }

          nbSizes += 1
        }

        // console.log('[imageLocationsFromTpl]', CROP_STORE.length - 1, size, crop)
        storage.srcsets.push(srcsetObj)
        storage.default_img = getDefaultImgName(size)
        storage.img_base = size
      })

      locations[removeFileExtension(tplName)] = [storage]
    })
  })
}

/**
 * Export all data as CSV
 */
function exportCSV() {
  const CSVInfo = []
  const json2csvParser = new Json2csvParser({
    fields,
    unwind: 'sizes',
  })
  let csv

  for (let location in locations) {
    const srcsets = locations[location][0].srcsets
    const CSVObj = {
      location,
      sizes: [],
    }

    CSVInfo.push(CSVObj)

    srcsets.forEach(val => {
      const splitSize = val.size.split('-')

      CSVObj.sizes.push({
        retina: val.srcset === '2x' ? '✓' : '×',
        width: splitSize[1] + 'px',
        height: splitSize[2] + 'px',
        ratio: splitSize[1] / splitSize[2],
      })
    })
  }

  csv = json2csvParser.parse(CSVInfo)
  csv = csv.replace(new RegExp('sizes.', 'g'), '')
  createFile(path.imagesSizesCsv, csv)
}

/**
 * Init function
 */
function init() {
  const spinner = ora('Generate image locations and sizes JSON files').start()
  imageLocationsFromTpl()

  createJsonFile(path.imageLocationsJson, [locations])
  createJsonFile(path.imagesSizesJson, [sizes])

  if (isExport) {
    exportCSV()
    spinner.succeed(
      `JSON files successfully generated !\nNumber of locations : ${nbLocations} \nNumber of sizes : ${nbSizes} \nCSV exported`
    )
    return
  }
  spinner.succeed(
    `JSON files successfully generated !\nNumber of locations : ${nbLocations} \nNumber of sizes : ${nbSizes}`
  )
}

init()
