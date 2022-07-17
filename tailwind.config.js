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
                'blue_navy_bg':"url('https://hypnos63.s3.eu-west-3.amazonaws.com/solid-navy-blue.jpg')",
                'blue_concrete_bg':"url('https://hypnos63.s3.eu-west-3.amazonaws.com/blue-concrete.jpg')",
                'bg_connect':"url('https://hypnos63.s3.eu-west-3.amazonaws.com/bg-connection.jpg')",
                'bg_contact':"url('https://hypnos63.s3.eu-west-3.amazonaws.com/bg-contact.jpg')",
                'bg_register':"url('https://hypnos63.s3.eu-west-3.amazonaws.com/bg-register.jpg')",
                'bg_space':"url('https://hypnos63.s3.eu-west-3.amazonaws.com/bg-space.jpg')"
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