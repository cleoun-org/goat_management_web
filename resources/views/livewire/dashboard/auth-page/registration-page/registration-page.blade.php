<div class="container sm:px-10">
    <div class="block xl:grid grid-cols-2 gap-4">
        <!-- BEGIN: Register Info -->
        <div class="hidden xl:flex flex-col min-h-screen">
            <a href="" class="-intro-x flex items-center pt-5">
                <img alt="Tinker Tailwind HTML Admin Template" class="w-6" src="/assets/core/images/logo.svg">
                <span class="text-white text-lg ml-3"> {{ config('app.name') }} </span>
            </a>
            <div class="my-auto">
                <img alt="Tinker Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="/assets/core/images/illustration.svg">
                <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                    Satu Lankah Lagi!!
                    <br>
                    Dan Anda Bergabung Bersama Kami
                </div>
                <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500">Segera daftarkan dirimu dan temukan undangan favorit kamu</div>
            </div>
        </div>
        <!-- END: Register Info -->
        <!-- BEGIN: Register Form -->
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
            <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Buat Akun
                </h2>
                <div class="intro-x mt-2 text-gray-500 dark:text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                <div class="intro-x mt-8">
                    <input type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" wire:model.defer="name" placeholder="Nama">
                    @error('name')
                        <span class="mt-3 ml-1 p-0" style="color: #ff4747">{{ $message }}</span>
                    @enderror
                    <input type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" wire:model.defer="username" placeholder="Username">
                    @error('username')
                        <span class="mt-3 ml-1 p-0" style="color: #ff4747">{{ $message }}</span>
                    @enderror
                    <input type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" wire:model.defer="phone_number" placeholder="nomor telepon">
                    @error('phone_number')
                        <span class="mt-3 ml-1 p-0" style="color: #ff4747">{{ $message }}</span>
                    @enderror
                    <input type="email" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" wire:model.defer="email" placeholder="Email">
                    @error('email')
                        <span class="mt-3 ml-1 p-0" style="color: #ff4747">{{ $message }}</span>
                    @enderror
                    <input type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" wire:model.defer="password" placeholder="Password"> 
                    @error('password')
                        <span class="mt-3 ml-1 p-0" style="color: #ff4747">{{ $message }}</span>
                    @enderror
                    <input type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" wire:model.defer="password_c" placeholder="Konfirmasi Password">
                    @error('password_c')
                        <span class="mt-3 ml-1 p-0" style="color: #ff4747">{{ $message }}</span>
                    @enderror
                    <input type="hidden" wire:model.defer="lat" id="lat">
                    <input type="hidden" wire:model.defer="lon" id="lon">
                </div>
                <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                    <input id="privacy-acception" type="checkbox" class="form-check-input border mr-2" wire:model.defer="privacy_policy">
                    <label class="cursor-pointer select-none" for="privacy-acception">Saya setuju dengan kebijakan <a class="text-theme-25 dark:text-theme-22 ml-1" href="">Aturan & Privasi</a> dari Dy<strong>Ve</strong> </label>
                </div>
                @error('privacy_policy')
                    <span class="mt-3 ml-1 p-0" style="color: #ff4747">{{ $message }}</span>
                @enderror
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
                        wire:click="register" wire:loading.attr="disabled">

                        <span wire:loading.remove>Daftar</span>
                            
                        <div wire:loading.flex style="justify-content: center; align-items: center; margin: 0px; padding: 5px 0px">
                            <svg width="25" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="rgb(226, 232, 240)" class="w-8 h-7">
                                <circle cx="15" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="60" cy="15" r="9" fill-opacity="0.3">
                                    <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
                                </circle>
                                <circle cx="105" cy="15" r="15">
                                    <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                    <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                                </circle>
                            </svg>
                        </div>
                    
                    </button>

                    <a href="{{ route('login') }}" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Log In</a>
                </div>
            </div>
        </div>
        <!-- END: Register Form -->
    </div>

    <script>
    
    if (navigator.geolocation) {
    // Request user's location
        navigator.geolocation.getCurrentPosition(assign, showError);
    } else {
        console.log("Geolocation is not supported by this browser.");
    }

    function assign(position) {
        // Display user's latitude and longitude
        document.getElementById('lat').value = position.coords.latitude;
        document.getElementById('lon').value = position.coords.longitude;
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
            console.log("User denied the request for Geolocation.");
            break;
            case error.POSITION_UNAVAILABLE:
            console.log("Location information is unavailable.");
            break;
            case error.TIMEOUT:
            console.log("The request to get user location timed out.");
            break;
            case error.UNKNOWN_ERROR:
            console.log("An unknown error occurred.");
            break;
        }
    }

    
    </script>
</div>