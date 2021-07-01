const plugin = require('tailwindcss/plugin')

module.exports = {
  purge: ['*.php'],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      fontFamily: {
        roboto: 'Roboto',
      },
      fontSize: {
        h1: ['48px', 1.26],
      },
      colors: {
        purple: '#6b51ed',
        'light-blue': '#f0f6f8',
        blue: '#13b4e2',
        'dark-blue': '#163467',
        yellow: '#ffcf63',
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    plugin(function ({ addUtilities, theme }) {
      const colors = theme('colors')
      const hasBackgroundColorUtilities = Object.keys(colors).map((key) => {
        return {
          [`.has-${key}-background-color`]: {
            backgroundColor: `${colors[key]}`,
          },
        }
      })
      addUtilities(hasBackgroundColorUtilities)
    }),
  ],
}
