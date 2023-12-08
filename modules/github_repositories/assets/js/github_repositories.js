/**
 *
 * Search the top 10 GitHub repositories by language
 *
 */
function githubRepositoriesData() {

    const config = {
        method: 'GET',
        mode: 'same-origin',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
    };

    return {
        // progress bar
        speed: 20,
        width: 0,
        id: 0,

        // search data
        searchTerm: 'PHP',
        errorMessage: '',
        repositories: [],


        getRepositories(apiPath) {
            let args = {};
            args['search_term'] = this.searchTerm;
            const queryParams = new URLSearchParams(args);

            // Send request to the api endpoint
            fetch(apiPath + '?' + queryParams.toString(), config)
                .then((response) => response.json())
                .then((data) => {
                    if (!data) {
                        console.log('Error');
                    } else if (data.error) {
                        console.log(data.error)
                    } else {
                        const results = JSON.parse(data);
                        this.repositories = results.items
                        this.width = 100;
                    }

                });
        },


        // start progress bar
        triggerMove() {
            this.id = window.setInterval(() => this.move(), this.speed);
        },

        // move it
        move() {
            if (this.width === 100) {
                clearInterval(this.id);
                this.width = 0;
            } else {
                this.width++;
            }
        }

    };

}

document.addEventListener('alpine:init', () => {
    Alpine.data('githubRepositoriesData', githubRepositoriesData);
});
