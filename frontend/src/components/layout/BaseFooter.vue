<template>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <section class="py-8 text-white border-t-4 rounded-t-md shadow-2xl border-sky-700 bg-sky-600 ">
        <div class="mx-auto w-full justify-center align-middle ">
            <div class="grid grid-cols px-4 grid-cols-1 lg:grid-cols-5 ">

                <!-- Contact Info -->


                <!-- Info Detail -->
                <div class="w-4/5 mx-auto justify-center text-center grid col-span-2">
                    <RouterLink to="/" class="flex items-center justify-center space-x-3">
                        <span class="text-3xl text-center text-sky-950 font-bold mb-4 self-center">Buzz<i
                                class="fa-solid fa-bolt text-white"></i>Shop</span>
                    </RouterLink>
                    <p
                        class="w-full border-t-2 text-base 2xl:text-lg border-gray-100 border-dashed border-opacity-70 py-4 italic">
                        Táplálékkiegészítők, kondigépek online vásárlása, rendelése. Kedvező árak, gyors házhozszállítás
                    </p>

                    <div class="w-full flex flex-row text-base 2xl:text-lg py-4 italic">
                        <div class="mx-auto">
                            <a href="/"
                                class="w-sm px-1 mx-auto self-center hover:text-lime-300 text-center">Főoldal</a>
                        </div>
                        <div class="mx-auto">
                            <a href="/brands"
                                class="w-sm px-1 mx-auto self-center hover:text-lime-300 text-center">Gyártók</a>
                        </div>

                        <div class="mx-auto">
                            <a href="/proteins"
                                class="w-sm px-1 mx-auto self-center hover:text-lime-300 text-center">Táplálékkiegészítők</a>

                        </div>

                        <div class="mx-auto"><a href="/delivery"
                                class="w-sm px-1 mx-auto self-center hover:text-lime-300 text-center">Szállítás</a>
                        </div>



                    </div>
                    <div class="w-full flex flex-row text-base 2xl:text-lg py-4 italic">
                        <div class="mx-auto">
                            <a href="/login" class="w-fit hover:text-lime-300 text-center">Bejelentkezés</a>
                        </div>

                        <div class="mx-auto"><a href="/payment"
                                class="w-fit hover:text-lime-300 text-center">Fizetés</a>
                        </div>

                        <div class="mx-auto"> <a href="/clothes"
                                class="w-fit hover:text-lime-300 text-center">Sportruhák</a></div>

                        <div class="mx-auto text-center flex justify-center align-middle">
                            <a href="/contact" class="w-fit hover:text-lime-300 text-center">Kapcsolat</a>
                        </div>
                    </div>
                </div>


                <div class="grid col-span-2 w-4/5 md:w-3/4 mx-auto mt-4 lg:mt-0">
                    <h4 class="text-2xl text-center text-sky-50 font-bold uppercase mb-4">Feliratkozás</h4>
                    <h5
                        class="font-semibold text-center py-2 2xl:text-xl lg:text-lg md:text-sm text-amber-50 italic border-t-2 border-gray-100 border-opacity-10">
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

                <div class="grid grid-cols-1 w-full md:w-3/4 lg:w-5/6 mx-auto justify-center align-top mt-12 md:mt-0">
                    <div class="grid pt-2 2xl:text-lg justify-center my-auto mr-4 font-semibold">
                        <h4 class="text-3xl text-sky-50 font-bold mb-4">Elérhetőség</h4>
                    </div>
                    <div class="contact-container md:border-t-2 md:border-gray-100 md:border-opacity-10">
                        <div class="contact-grid justify-center py-4">
                            <div class="contact-item mx-auto lg:m-auto">
                                <i class="fa fa-phone"></i>
                                <span class="contact-text">+36 1 123 4567</span>
                            </div>
                            <div class="contact-item mx-auto lg:m-auto">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <span class="contact-text">1111 Kozma u. 13.</span>
                            </div>
                            <div class="contact-item mx-auto lg:m-auto">
                                <i class="fa fa-envelope"></i>
                                <span class="contact-text">info@buzzshop.com</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 py-4 w-full justify-center items-center mx-auto align-middle mt-4
                        border-y-2 border-gray-100 border-dashed border-opacity-70 
                        ">
                        <a href="" class="text-white text-center transition-all ease-in-out duration-200">
                            <i class="fab fa-facebook fa-2x hover:bg-sky-800 shadow-md rounded-full "
                                aria-hidden="true"></i>
                        </a>
                        <a href=""
                            class="text-blue-50 text-center hover:text-yellow-400 transition-all ease-in-out duration-200">
                            <i class="fab fa-twitter fa-2x" aria-hidden="true"></i>
                        </a>
                        <a href=""
                            class="text-white bg-inherit text-center hover:text-sky-100 transition-all ease-in-out duration-200 ">
                            <i class="fab fa-linkedin fa-2x"></i>
                        </a>
                        <a href=""
                            class="text-pink-400 text-center hover:text-red-600 transition-all ease-in-out duration-200">
                            <i class="fab fa-instagram fa-2x " aria-hidden="true"></i>
                        </a>
                    </div>

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
    background-position: 100% 100%;
    box-shadow:
        0 6px 20px rgba(0, 0, 0, 0.15),
        inset 0 0 0 1px rgba(255, 255, 255, 0.3);
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: clamp(0.875rem, 1vw + 0.5rem, 1.125rem);
}

.contact-text {
    overflow-wrap: break-word;
    word-wrap: break-word;
    hyphens: auto;
}

.container {
    width: 100%;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 0.4rem;
}
</style>