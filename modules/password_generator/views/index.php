<section x-data="safePasswordData">
    <h1 style="text-align: left;">Safe password generator</h1>

    <div class="panel danger" x-show="errorMessage" x-cloak>
        <span x-text="errorMessage"></span>
    </div>

    <div class="gray-20 content-250">
        <div id="indicator" class="box green center"
             :style="{ width: strength, height: '0.5em', 'background-color': indicatorColor }">
        </div>
    </div>

    <label for="length" class="margin-top-0">Password length: <span class="fs-24" x-text="length"></span></label>
    <input type="range" @click="setStrength" name="length"
           x-model="length" min="8" max="50" step="1" style="max-width: 300px">

    <div class="checkbox-group">
        <label for="lowercase" class="margin-bottom-0-5">
            <input type="checkbox" name="characters" x-model="lowercase">
            Lowercase letters</label>

        <label for="uppercase" class="margin-bottom-top-0-5">
            <input type="checkbox" name="characters" x-model="uppercase">
            Uppercase letters</label>

        <label for="number" class="margin-bottom-top-0-5">
            <input type="checkbox" name="characters" x-model="numbers">
            Numbers</label>

        <label for="symbol" class="margin-bottom-top-0-5">
            <input type="checkbox" name="characters" x-model="symbols">
            Special chars</label>
    </div>

    <button @click="getPassword('<?= BASE_URL ?>' + 'password_generator/generate/')" class="primary">
        Generate password
    </button>


    <h2 class="h4">Generated password:</h2>
    <div>
        <input x-ref="mypassword" type="text" x-model="password" style="max-width: 500px; height: 60px;">
    </div>

    <button :class="isCopied() ? 'success' : ''" @click="copyToClipboard">
        <i :class="isCopied() ? 'fa fa-check' : 'fa fa-clone'" aria-hidden="true"></i>
        <span x-text="copyText">Copy it</span>
    </button>

</section>

<script src="password_generator_module/js/password_generator.js"></script>
