<template>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <section class="py-8 text-white border-t-4 rounded-t-md shadow-2xl border-sky-700 bg-sky-600 ">
        <div class="mx-auto w-full ">
            <div class="grid grid-cols px-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 ">
                <!-- Contact Info -->
                <div class="mx-auto w-auto">
                    <h4 class="text-3xl text-sky-50 font-bold mb-4">Elérhetőség</h4>

                    <div class="w-fit pt-2 2xl:text-lg font-semibold border-t-2 border-sky-100 border-dashed border-opacity-70">
                        <a href="#" class="flex items-center space-x-2 py-1">
                            <i class="fa-solid fa-map-location-dot text-center" aria-hidden="true"></i>
                            <div class="hover:text-lime-300">1111 Kozma u. 13.</div>
                        </a>
                        <a href="#" class="flex items-center space-x-2 py-1">
                            <i class="fa fa-phone text-center" aria-hidden="true"></i>
                            <div class="hover:text-lime-300">+36 1 123 4567</div>
                        </a>
                        <a href="#" class="flex items-center space-x-2 py-1">
                            <i class="fa fa-envelope text-center" aria-hidden="true"></i>
                            <div class="hover:text-lime-300">info@buzzshop.com</div>
                        </a>
                    </div>

                    <div class="flex max-w-fit justify-normal space-x-4 lg:justify-between  sm:justify-normal
                         sm:space-x-4 md:justify-start md:space-x-5 md:mt-4 md:py-4 py-3 
                        border-y-2 border-gray-100 border-dashed border-opacity-70 
                        ">
                        <a href="" class="text-white transition-all ease-in-out duration-200">
                            <i class="fab fa-facebook fa-2x hover:bg-sky-800 shadow-md rounded-full "
                                aria-hidden="true"></i>
                        </a>
                        <a href="" class="text-blue-50 hover:text-yellow-400 transition-all ease-in-out duration-200">
                            <i class="fab fa-twitter fa-2x" aria-hidden="true"></i>
                        </a>
                        <a href=""
                            class="text-white bg-inherit hover:text-sky-100 transition-all ease-in-out duration-200 ">
                            <i class="fab fa-linkedin fa-2x"></i>
                        </a>
                        <a href="" class="text-pink-400 hover:text-red-600 transition-all ease-in-out duration-200">
                            <i class="fab fa-instagram fa-2x " aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <!-- Info Detail -->
                <div class="w-fit mx-auto">
                    <RouterLink to="/" class="flex items-center justify-center space-x-3">
                        <span class="text-3xl text-center text-sky-950 font-bold mb-4 self-center">Buzz<i
                                class="fa-solid fa-bolt text-white"></i>Shop</span>
                    </RouterLink>
                    <p
                        class="max-w-fit border-t-2 text-base 2xl:text-lg border-gray-100 border-dashed border-opacity-70 py-4 italic">
                        Táplálékkiegészítők, kondigépek online vásárlása, rendelése. Kedvező árak, gyors házhozszállítás
                    </p>
                    <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-2 w-full lg:mt-2 text-base xl:text-lg font-semibold italic">
                        <a href="/" class="hover:text-lime-300">Főoldal</a>
                        <a href="/login" class="hover:text-lime-300">Bejelentkezés</a>
                        <a href="/brands" class="hover:text-lime-300">Gyártók</a>
                        <a href="/proteins" class="hover:text-lime-300">Táplálékkiegészítők</a>
                        <a href="/clothes" class="hover:text-lime-300">Sportruházatok</a>
                        <a href="/contact" class="hover:text-lime-300">Kapcsolat</a>
                        <a href="/delivery" class="hover:text-lime-300">Szállítás</a>
                        <a href="/payment" class="hover:text-lime-300">Fizetés</a>
                    </div>
                </div>


                <div class="w-fit mx-auto mt-4 sm:mt-0">
                    <h4 class="text-2xl text-sky-50 font-bold uppercase mb-4">Feliratkozás</h4>
                    <h5
                        class="font-semibold py-2 2xl:text-xl lg:text-lg md:text-sm text-amber-50 italic border-t-2 border-gray-100 border-opacity-10">
                        Értesülj elsőkként az újdonságainkról!
                    </h5>
                    <form action="#" class="space-y-3">
                        <input type="text" placeholder="e-mail cím"
                            class="w-full p-2 pl-2 text-sky-900 font-semibold border-4 border-sky-700/55 rounded-md" />
                        <button type="submit" id="newsletter"
                            class="w-full bg-lime-500 font-semibold py-2 rounded-md hover:bg-lime-600 hover:border hover:border-white hover:border-opacity-25 hover:text-amber-50">
                            Hírlevél feliratkozás
                        </button>
                        <div class="w-full italic text-sm lg:text-sm md:text-left xl:px-2 ">*A hírlevélre való
                            feliratkozással elfogadod az
                            általános <u>szerződési feltételeket.</u></div>
                    </form>
                </div>
            </div>
        </div>

    </section>
</template>

<style>
#newsletter {
    cursor: pointer;
    color: rgba(3, 77, 151, 0.9) !important;
    font-weight: 800;
    padding: 10px;
    background-size: 200% 200%;
    background-image: linear-gradient(145deg,
            rgba(155, 234, 238, 0.8) 0%,
            rgba(27, 201, 198, 0.6) 50%,
            rgba(2, 142, 164, 0.9) 50%,
            rgba(1, 47, 63, 0.9) 100%);
    background-position: 0 0;
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    box-shadow:
        0 4px 15px rgba(0, 0, 0, 0.1),
        inset 0 0 0 1px rgba(255, 255, 255, 0.1);
    transition: all 0.7s ease;
}

#newsletter:hover {
    color: white !important;
    background-position: 100% 100%;
    box-shadow:
        0 6px 20px rgba(0, 0, 0, 0.15),
        inset 0 0 0 1px rgba(255, 255, 255, 0.3);
}
</style>