/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,js}",
    "./resources/**/*.blade.php",
    "./node_modules/tw-elements/dist/js/**/*.js",
    "./components/**/*.{js,ts,jsx,tsx,css,woff}",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    screens: {
      'xxsm': '280px',
      // => @media (min-width: 280px) { ... }

      'xsm': '360px',
      // => @media (min-width: 360px) { ... }

      'msm': '480px',
      // => @media (min-width: 480px) { ... }

      'sm': '640px',
      // => @media (min-width: 640px) { ... }

      'md': '768px',
      // => @media (min-width: 768px) { ... }

      'xmd': '840px',
      // => @media (min-width: 880px) { ... }

      'xxmd': '920px',
      // => @media (min-width: 920) { ... }

      'lg': '1024px',
      // => @media (min-width: 1024px) { ... }

      'xlg': '1120px',
      // => @media (min-width: 1100px) { ... }

      'xl': '1280px',
      // => @media (min-width: 1200px) { ... }

      '1xl': '1450px',
      // => @media (min-width: 1300) { ... }

      '2xl': '1600px',
      // => @media (min-width: 1600px) { ... }
    },
    extend: {
        fontFamily: {
          'fira-sans': ['Fira Sans']
        },
        colors:{
            'primary': ({ opacityVariable, opacityValue }) => {
                return `var(--site_color)`;
            },
            'blue-300':'#93c5fd',
            'black-dark':'#161616',
            'black':'#020613',
            'white-50':'#FFFFFF',
            'white':'#FFFFFF',
            'white-100':'#DBDBDC',
            'slate':'#EAEAEA',
            'gray':'#666666',
            'gray-50':'#f3f4f6',
            'gray-100':'#808587',
            'gray-200':'#F9FAFB',
            'gray-light':'#D9D9D9',
            'white-light':'#D8D8D8',
            'slate-light':'#F0F4F5',
            'slate-100':'#f1f5f9',
            'yellow':'#F2AE00',
            'blue':'#004753',
            'red':'#BF0202',
            'red-100':'#fee2e2',
            'green':'#22c55e',
            'green-100':'#dcfce7',
            'sky':'#38bdf8',
            'sky-100':'#e0f2fe',         
            'yellow-100':'#fef9c3',
            'light-green':'#F4FBFD',
            'primary-100': ({ opacityVariable, opacityValue }) => {
                return `var(--site_color)`;
         
            },
            'transparent': 'transparent',
        },
    },
  },
  plugins: [
    require("tailwindcss"),
    require("tw-elements/dist/plugin"),
    require('flowbite/plugin'),
    require('tailwindcss-rtl'),
  ],
}
