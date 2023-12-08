/*
*  Safe password data component
*
* */
export function safePasswordData() {

    const config = {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        mode: 'same-origin', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            'Content-Type': 'application/json'
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        // body: JSON.stringify(params) // body data type must match "Content-Type" header
    };

    return {
        copyText: 'Copy it',
        length: 15,
        lowercase: true,
        uppercase: false,
        numbers: true,
        symbols: false,
        strength: '66%',
        indicatorColor: '#e1e44c',
        password: '',


        setStrength() {
            if (this.length < 14) {
                this.strength = '33%';
                this.indicatorColor = 'red';

            } else if (this.length >= 14 && this.length < 18) {
                this.strength = '66%';
                this.indicatorColor = '#e1e44c';

            } else if (this.length >= 18) {
                this.strength = '100%'
                this.indicatorColor = 'green';
            }
        },

        isCopied() {
            return this.copyText === 'Copied to clipboard!';
        },

        copyToClipboard() {
            const textToCopy = this.$refs.mypassword.value;

            navigator.clipboard.writeText(textToCopy).then(() => {
                // Alert the user that the action took place.
                this.copyText = 'Copied to clipboard!';
                setTimeout(() => {
                    this.copyText = 'Copy it';
                }, 3000)
            })
        },

        getPassword(apiPath) {

            let args = {};
            args['length'] = this.length;
            args['lowercase'] = this.lowercase;
            args['uppercase'] = this.uppercase;
            args['numbers'] = this.numbers;
            args['symbols'] = this.symbols;

            const queryParams = new URLSearchParams(args);

            // Send request to the api endpoint
            fetch(apiPath + '?' + queryParams.toString(), config)
                .then((response) => response.json())
                .then((data) => {
                    if (!data) {
                        return;
                    }
                    console.log(data)
                    this.password = data.password
                });

        }
    }


}
