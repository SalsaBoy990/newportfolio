<section x-data="githubRepositoriesData">

    <h1 style="text-align: left;">Top 10 list of repositories by language</h1>

    <div class="content-600">
        <label for="language">Type in your programming language:</label>
        <input name="language" x-model="searchTerm" type="text" value="">


            <div x-cloak x-show="width" class="gray-20">
                <div class="box gray-60" style="width: 0; height: 8px;" :style="{ width: (width + '%') }"></div>
            </div>

        <button @click="triggerMove();getRepositories('<?= BASE_URL ?>' + 'github_repositories/repositories/')" type="submit"
                class="primary">Submit
        </button>

    </div>

    <div x-cloak>
        <h2 class="h3">Search results:</h2>
        <table>
            <thead>
            <tr>
                <th>Repo name</th>
                <th>Stars</th>
                <th>Short description</th>
                <th>Link to the repo</th>
            </tr>
            </thead>
            <tbody>
            <template x-for="repository in repositories" :key="repository.id">
                <tr>
                    <td>
                        <b x-text="repository.full_name"></b>
                    </td>
                    <td>
                        <b class="orange-dark text-white" x-text="repository.stargazers_count"></b>
                    </td>
                    <td class="fs-14" x-text="repository.description"></td>
                    <td>
                        <a :href="repository.html_url" target="_blank">Link</a>
                    </td>
                </tr>
            </template>

            </tbody>
        </table>
    </div>

</section>

<script src="github_repositories_module/js/github_repositories.js"></script>
