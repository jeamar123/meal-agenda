/** @type {import('tailwindcss').Config} */
export default {
  corePlugins: {
    container: false,
  },
  theme: {
    extend: {
      colors: {
        light: {
          primary: '#0e94e9',
          secondary: '#035da1',
          header: {
            border: '#333',
          },
          card: {
            border: '#333',
          },
          form: {
            border: '#333',
          },
          body: '#f3f3f3',
          text: '#333',
        },

        dark: {
          primary: '#0e94e9',
          secondary: '#035da1',
          header: {
            border: '#e4e4e7',
          },
          card: {
            border: '#d4d4d8',
          },
          form: {
            border: '#a9a9af',
          },
          body: '#0f172a',
          text: '#cbd5e1',
        }
      },
      fontFamily: {
        sans: [
          'Inter',
          '"Helvetica Neue"',
          'Arial',
          'sans-serif',
        ],
        headline: [
          'Inter',
          '"Helvetica Neue"',
          'Arial',
          'sans-serif',
        ],
      },
    },
  },
  plugins: [
    ({ addComponents, theme }) => {
      addComponents({
        '.container': {
          width: '100%',
          marginLeft: 'auto',
          marginRight: 'auto',
          maxWidth: '1560px',
          paddingLeft: theme('spacing.6'),
          paddingRight: theme('spacing.6'),
          '@screen md': {
            paddingLeft: theme('spacing.12'),
            paddingRight: theme('spacing.12'),
          },
          '@screen lg': {
            paddingLeft: theme('spacing.24'),
            paddingRight: theme('spacing.24'),
          },
        },
      })
    },
  ],
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
}

