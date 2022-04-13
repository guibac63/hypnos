module.exports = {
    content: [
        "./assets/**/*.{vue,js,ts,jsx,tsx}",
        "./templates/**/*.{html,twig}"
    ],
    theme: {
        fontFamily:{
            'open-sans':['"Open Sans"','"Segoe UI"','Arial'],
            'Volkorn_Regular':['Volkorn_Regular','Arial'],
            'Volkorn_SemiBold':['Volkorn_SemiBold','Arial']
        },
        extend: {
            backgroundImage: {
                'blue_navy_bg':"url('/public/images/background/solid-navy-blue.jpg')",
                'blue_concrete_bg':"url('/public/images/background/blue-concrete.jpg')",
                'bg_connect':"url('/public/images/background/bg-connection.jpg')",
                'bg_contact':"url('/public/images/background/bg-contact.jpg')",
                'bg_register':"url('/public/images/background/bg-register.jpg')"
            },
            colors:{
                'yellow_hypnos':'#EBE645',
                'blue_light_hypnos':'#577BC1',
                'blue_medium_hypnos':'#344CB7',
                'blue_dark_hypnos':'#03256C',
            },
            height:{
              'home-full': '700px',
              'home-middle': '450px',
            },
        },
    },
    plugins: [],
}