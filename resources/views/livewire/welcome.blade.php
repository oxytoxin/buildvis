<div>
    <section x-data="{ mobileNavOpen: false }" class="bg-orange-50">
        <nav class="py-6 border-b">
            <div class="container mx-auto px-4">
                <div class="relative flex items-center justify-between">
                    <a href="{{ route('welcome') }}" class="inline-block">
                        <img class="h-28" src="images/logo-transparent.png" alt="logo">
                    </a>
                    <ul class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 hidden md:flex">
                        <li class="mr-8"><a class="inline-block text-teal-900 hover:text-teal-700 font-medium" href="#">About us</a></li>
                        <li class="mr-8"><a class="inline-block text-teal-900 hover:text-teal-700 font-medium" href="#">Team</a></li>
                        <li class="mr-8"><a class="inline-block text-teal-900 hover:text-teal-700 font-medium" href="#">Solutions</a></li>
                        <li><a class="inline-block text-teal-900 hover:text-teal-700 font-medium" href="#">Blog</a></li>
                    </ul>
                    <div class="flex items-center justify-end">
                        <div class="hidden md:block">
                            <a href="#" class="inline-flex py-2.5 px-4 items-center justify-center text-sm font-medium text-teal-900 hover:text-white border border-teal-900 hover:bg-teal-900 rounded-full transition duration-200">Visit Store</a>
                        </div>
                        <button x-on:click="mobileNavOpen = !mobileNavOpen" class="md:hidden navbar-burger text-teal-900 hover:text-teal-800">
                            <svg width="32" height="32" viewbox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.19995 23.2H26.7999" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M5.19995 16H26.7999" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M5.19995 8.79999H26.7999" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
        <div class="relative pt-18">
            <img class="hidden md:block absolute top-0 left-0 mt-28 w-32 lg:w-64 rounded-r-2xl" src="https://images.unsplash.com/photo-1561343228-e6a5c693d352?crop=entropy&amp;cs=srgb&amp;fm=jpg&amp;ixid=M3wzMzIzMzB8MHwxfHNlYXJjaHwyNHx8Y29uc3RydWN0aW9ufGVufDB8MXx8fDE3Mzk0Njk2NDF8MA&amp;ixlib=rb-4.0.3&amp;q=85&amp;w=1920" alt="">
            <img class="hidden md:block absolute top-0 right-0 mt-20 lg:w-64 rounded-2xl w-48" src="https://images.unsplash.com/photo-1610551675799-50d4d0fe0252?crop=entropy&amp;cs=srgb&amp;fm=jpg&amp;ixid=M3wzMzIzMzB8MHwxfHNlYXJjaHwzfHxjb25zdHJ1Y3Rpb258ZW58MHwyfHx8MTczOTQ2OTQ3Mnww&amp;ixlib=rb-4.0.3&amp;q=85&amp;w=1920" alt="">
            <div class="container mx-auto px-4 relative">
                <div class="max-w-lg xl:max-w-xl mx-auto mb-12 lg:mb-0 text-center">
                    <h1 class="font-heading text-5xl xs:text-7xl xl:text-8xl tracking-tight mb-8 mt-8">From Vision to Reality</h1>
                    <div class="flex mb-6 items-center justify-center">
                        <span class="ml-2 font-medium text-lg">3D Modeling + Real-Time Budgeting = Unstoppable Efficiency</span>
                    </div>
                    <p class="text-lg text-gray-700 mb-10">Why wait months for estimates? BuildVis delivers 3D models and material lists in minutes.</p>
                    <div class="flex flex-col sm:flex-row justify-center">
                        <a href="{{ route('login') }}" class="inline-flex py-4 px-6 mb-3 sm:mb-0 sm:mr-4 items-center justify-center text-lg font-medium text-white hover:text-teal-900 border border-teal-900 hover:border-lime-500 bg-teal-900 hover:bg-lime-500 rounded-full transition duration-200">Start Building</a>
                        <a href="{{ route('register') }}" class="inline-flex py-4 px-6 items-center justify-center text-lg font-medium text-black hover:text-white border border-teal-900 hover:bg-teal-900 rounded-full transition duration-200">Sign Up for Free</a>
                    </div>
                </div>
                <div class="flex -mx-4 items-end relative">
                    <div class="w-1/3 xs:w-1/2 lg:w-auto px-4">
                        <img class="block h-32 lg:h-48" src="flow-assets/headers/header-4-bottom-lleft.png" alt="">
                    </div>
                    <div class="w-2/3 xs:w-1/2 lg:w-auto ml-auto px-4">
                        <img class="block w-1/2 md:w-64 ml-auto rounded-t-2xl" src="https://images.unsplash.com/photo-1603814929877-d5d927322656?crop=entropy&amp;cs=srgb&amp;fm=jpg&amp;ixid=M3wzMzIzMzB8MHwxfHNlYXJjaHwzMXx8Y29uc3RydWN0aW9ufGVufDB8MXx8fDE3Mzk0Njk2NDF8MA&amp;ixlib=rb-4.0.3&amp;q=85&amp;w=1920" alt="">
                    </div>
                    <div class="absolute bottom-0 left-0 w-full py-32 bg-gradient-to-t from-orange-50 to-transparent"></div>
                </div>
            </div>
        </div>
        <div :class="{ 'block': mobileNavOpen, 'hidden': !mobileNavOpen }" class="hidden fixed top-0 left-0 bottom-0 w-full xs:w-5/6 xs:max-w-md z-50">
            <div x-on:click="mobileNavOpen = !mobileNavOpen" class="fixed inset-0 bg-violet-900 opacity-20"></div>
            <nav class="relative flex flex-col py-6 px-4 w-full h-full bg-white overflow-y-auto">
                <div class="flex items-center justify-between">
                    <a href="#" class="inline-block">
                        <img class="h-28" src="/images/logo-transparent.png" alt="logo">
                    </a>
                    <div class="flex items-center">
                        <a href="#" class="inline-flex py-2.5 px-4 mr-6 items-center justify-center text-sm font-medium text-teal-900 hover:text-white border border-teal-900 hover:bg-teal-900 rounded-full transition duration-200">Visit Store</a>
                        <button x-on:click="mobileNavOpen = !mobileNavOpen">
                            <svg width="32" height="32" viewbox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23.2 8.79999L8.80005 23.2M8.80005 8.79999L23.2 23.2" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="pt-20 pb-12 mb-auto">
                    <ul class="flex-col">
                        <li class="mb-6">
                            <a class="inline-block text-teal-900 hover:text-teal-700 font-medium" href="#">About us</a>
                        </li>
                        <li class="mb-6">
                            <a class="inline-block text-teal-900 hover:text-teal-700 font-medium" href="#">Team</a>
                        </li>
                        <li class="mb-6">
                            <a class="inline-block text-teal-900 hover:text-teal-700 font-medium" href="#">Solutions</a>
                        </li>
                        <li>
                            <a class="inline-block text-teal-900 hover:text-teal-700 font-medium" href="#">Blog</a>
                        </li>
                    </ul>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="#" class="inline-block mr-4">
                            <svg width="20" height="20" viewbox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_282_7847)">
                                    <path d="M11.548 19.9999V10.8776H14.6087L15.0679 7.32146H11.548V5.05136C11.548 4.02209 11.8326 3.32066 13.3103 3.32066L15.1918 3.31988V0.139123C14.8664 0.0968385 13.7495 -0.000106812 12.4495 -0.000106812C9.73488 -0.000106812 7.87642 1.65686 7.87642 4.69916V7.32146H4.8064V10.8776H7.87642V19.9999H11.548Z" fill="#022C22"></path>
                                </g>
                            </svg>
                        </a>
                        <a href="#" class="inline-block mr-4">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.8 2H16.2C19.4 2 22 4.6 22 7.8V16.2C22 17.7383 21.3889 19.2135 20.3012 20.3012C19.2135 21.3889 17.7383 22 16.2 22H7.8C4.6 22 2 19.4 2 16.2V7.8C2 6.26174 2.61107 4.78649 3.69878 3.69878C4.78649 2.61107 6.26174 2 7.8 2ZM7.6 4C6.64522 4 5.72955 4.37928 5.05442 5.05442C4.37928 5.72955 4 6.64522 4 7.6V16.4C4 18.39 5.61 20 7.6 20H16.4C17.3548 20 18.2705 19.6207 18.9456 18.9456C19.6207 18.2705 20 17.3548 20 16.4V7.6C20 5.61 18.39 4 16.4 4H7.6ZM17.25 5.5C17.5815 5.5 17.8995 5.6317 18.1339 5.86612C18.3683 6.10054 18.5 6.41848 18.5 6.75C18.5 7.08152 18.3683 7.39946 18.1339 7.63388C17.8995 7.8683 17.5815 8 17.25 8C16.9185 8 16.6005 7.8683 16.3661 7.63388C16.1317 7.39946 16 7.08152 16 6.75C16 6.41848 16.1317 6.10054 16.3661 5.86612C16.6005 5.6317 16.9185 5.5 17.25 5.5ZM12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C16.4732 9.40215 17 10.6739 17 12C17 13.3261 16.4732 14.5979 15.5355 15.5355C14.5979 16.4732 13.3261 17 12 17C10.6739 17 9.40215 16.4732 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7ZM12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C10.4413 14.6839 11.2044 15 12 15C12.7956 15 13.5587 14.6839 14.1213 14.1213C14.6839 13.5587 15 12.7956 15 12C15 11.2044 14.6839 10.4413 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9Z"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                        <a href="#" class="inline-block">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19 3C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19ZM18.5 18.5V13.2C18.5 12.3354 18.1565 11.5062 17.5452 10.8948C16.9338 10.2835 16.1046 9.94 15.24 9.94C14.39 9.94 13.4 10.46 12.92 11.24V10.13H10.13V18.5H12.92V13.57C12.92 12.8 13.54 12.17 14.31 12.17C14.6813 12.17 15.0374 12.3175 15.2999 12.5801C15.5625 12.8426 15.71 13.1987 15.71 13.57V18.5H18.5ZM6.88 8.56C7.32556 8.56 7.75288 8.383 8.06794 8.06794C8.383 7.75288 8.56 7.32556 8.56 6.88C8.56 5.95 7.81 5.19 6.88 5.19C6.43178 5.19 6.00193 5.36805 5.68499 5.68499C5.36805 6.00193 5.19 6.43178 5.19 6.88C5.19 7.81 5.95 8.56 6.88 8.56ZM8.27 18.5V10.13H5.5V18.5H8.27Z"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </section>

    <section class="p-4 bg-white">
        <div class="pt-16 pb-24 px-5 xs:px-8 xl:px-12 rounded-3xl">
            <div class="container mx-auto px-4">
                <div class="flex mb-4 items-center">
                    <svg width="8" height="8" viewbox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="4" cy="4" r="4" fill="#BEF264"></circle>
                    </svg>
                    <span class="inline-block ml-2 text-sm font-medium">Features</span>
                </div>
                <div class="border-t pt-14">
                    <h1 class="font-heading text-4xl sm:text-6xl mb-24">Pioneering the Future of Construction Planning</h1>
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-full sm:w-1/2 lg:w-1/4 px-4 mb-12 lg:mb-0">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bg-lime-500 rounded-lg w-14 h-14 p-2" viewbox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"></path>
                                    <path
                                        d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z">
                                    </path>
                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"></path>
                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"></path>
                                </svg>
                                <div class="mt-6">
                                    <h5 class="text-2xl font-medium mb-3">Instant Quotes</h5>
                                    <p class="text-gray-700 mb-6">Input your budget and get a 3D plan instantly.</p>

                                </div>

                            </div>
                        </div>
                        <div class="w-full sm:w-1/2 lg:w-1/4 px-4 mb-12 lg:mb-0">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" class="bg-lime-500 rounded-lg w-14 h-14 p-2">
                                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-8.9-5h7.45c.75 0 1.41-.41 1.75-1.03L21 4.96 19.25 4l-3.7 7H8.53L4.27 2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2zM12 2l4 4-4 4-1.41-1.41L12.17 7H8V5h4.17l-1.59-1.59L12 2z"></path>
                                </svg>
                                <div class="mt-6">
                                    <h5 class="text-2xl font-medium mb-3">Seamless Ordering</h5>
                                    <p class="text-gray-700 mb-6">Buy approved materials with one click.</p>

                                </div>

                            </div>
                        </div>
                        <div class="w-full sm:w-1/2 lg:w-1/4 px-4 mb-12 sm:mb-0">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="bg-lime-500 rounded-lg w-14 h-14 p-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>

                                <div class="mt-6">
                                    <h5 class="text-2xl font-medium mb-3">3D Material Catalog</h5>
                                    <p class="text-gray-700 mb-6">Browse hundreds of products in immersive detail. See your design come alive with photorealistic models.</p>

                                </div>

                            </div>
                        </div>
                        <div class="w-full sm:w-1/2 lg:w-1/4 px-4">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="bg-lime-500 rounded-lg w-14 h-14 p-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>

                                <div class="mt-6">
                                    <h5 class="text-2xl font-medium mb-3">Live Adjustments</h5>
                                    <p class="text-gray-700 mb-6">Swap materials and watch costs update in real time.</p>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="p-4">
        <div class="py-16 px-4 sm:px-8 bg-orange-50 rounded-3xl">
            <div class="container mx-auto px-4">
                <div class="flex mb-4 items-center"> <svg width="8" height="8" viewbox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="4" cy="4" r="4" fill="#022C22"></circle>
                    </svg> <span class="inline-block ml-2 text-sm font-medium text-teal-900">About us</span> </div>
                <div class="border-t pt-16">
                    <div class="max-w-lg mx-auto lg:max-w-none">
                        <div class="flex flex-wrap -mx-4">
                            <div class="w-full lg:w-2/3 px-4 mb-12 lg:mb-0">
                                <div class="max-w-xl">
                                    <h1 class="font-heading text-5xl sm:text-6xl mb-6">Building Smarter, Together</h1>
                                    <p class="text-lg text-gray-700">At <strong>BuildVis</strong>, we’re on a mission to transform the way construction projects are planned and executed. Our platform is built for anyone who’s ever struggled with budget overruns, design compromises, or the frustration of outdated planning tools.</p>
                                    <p class="text-lg text-gray-700 mt-3">We’re proud to offer features like budget-based material suggestions, interactive 3D models, and seamless inventory integration. But more than that, we’re proud to be a part of your journey to build something extraordinary.</p>
                                </div>
                            </div>
                            <div class="w-full lg:w-1/3 px-4">
                                <div>
                                    <div class="mb-16"> <span class="block text-5xl">500+</span>
                                        <p class="text-lg text-gray-700">Materials on Sale</p>
                                    </div>
                                    <div class="mb-16"> <span class="block text-5xl">1000+</span>
                                        <p class="text-lg text-gray-700">Quotes Created</p>
                                    </div>
                                    <div class="mb-16"> <span class="block text-5xl">10,000+</span>
                                        <p class="text-lg text-gray-700">Customers Served</p>
                                    </div>
                                    <div class="mb-16"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 lg:py-24 bg-teal-900">
        <div class="container mx-auto px-4">
            <div class="flex mb-4 items-center">
                <svg width="8" height="8" viewbox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="4" cy="4" r="4" fill="#BEF264"></circle>
                </svg>
                <span class="inline-block ml-2 text-sm font-medium text-white">FAQ</span>
            </div>
            <div class="border-t border-white border-opacity-25 pt-16">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full lg:w-1/2 px-4 mb-16 lg:mb-0">
                        <div class="flex flex-col h-full max-w-sm sm:max-w-lg">
                            <h1 class="font-heading text-4xl sm:text-6xl text-white mb-16">Answers to the frequently asked questions.</h1>
                            <div class="mt-auto">
                                <div class="mb-8">
                                    <svg width="48" height="48" viewbox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 8C0 3.58172 3.58172 0 8 0H40C44.4183 0 48 3.58172 48 8V40C48 44.4183 44.4183 48 40 48H8C3.58172 48 0 44.4183 0 40V8Z" fill="#BEF264"></path>
                                        <path d="M13.676 15.5617C11.7951 17.8602 10.6666 20.7983 10.6666 24C10.6666 27.2017 11.7951 30.1398 13.6761 32.4383L18.9201 27.1943C18.3372 26.2694 18 25.174 18 24C18 22.8259 18.3372 21.7306 18.92 20.8057L13.676 15.5617Z" fill="#022C22"></path>
                                        <path d="M15.5616 13.6761L20.8056 18.9201C21.7306 18.3372 22.8259 18 24 18C25.174 18 26.2694 18.3372 27.1943 18.9201L32.4383 13.6761C30.1398 11.7951 27.2017 10.6666 24 10.6666C20.7982 10.6666 17.8601 11.7951 15.5616 13.6761Z" fill="#022C22"></path>
                                        <path d="M34.3239 15.5617L29.0799 20.8057C29.6628 21.7307 30 22.8259 30 24C30 25.174 29.6627 26.2693 29.0799 27.1943L34.3238 32.4383C36.2048 30.1398 37.3333 27.2017 37.3333 24C37.3333 20.7983 36.2048 17.8602 34.3239 15.5617Z" fill="#022C22"></path>
                                        <path d="M32.4382 34.3239L27.1942 29.0799C26.2693 29.6628 25.174 30 24 30C22.8259 30 21.7307 29.6628 20.8057 29.0799L15.5617 34.3239C17.8602 36.2048 20.7983 37.3333 24 37.3333C27.2016 37.3333 30.1397 36.2048 32.4382 34.3239Z" fill="#022C22"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="text-xl font-medium text-white mb-4">Still have questions?</h5>
                                    <p class="text-white">
                                        <span class="opacity-80">For assistance, please visit our</span>
                                        <a href="#" class="inline-block text-white font-medium underline">Contact Us</a>
                                        <span class="opacity-80">page or call our customer support hotline at</span>
                                        <span class="text-white font-medium">+639000000000</span>
                                        <span class="opacity-80">. Our dedicated team is ready to help you on your journey to a greener, more sustainable future.</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 px-4">
                        <div>
                            <button x-data="{ accordion: false }" x-on:click.prevent="accordion = !accordion" class="flex w-full py-6 px-8 mb-4 items-start justify-between text-left bg-white shadow-md rounded-2xl">
                                <div class="pr-5">
                                    <h5 class="text-lg font-medium">What is BuildVis?</h5>
                                    <div x-ref="container" :style="accordion ? 'height: ' + $refs.container.scrollHeight + 'px' : ''" class="overflow-hidden h-0 duration-500">
                                        <p class="text-gray-700 mt-4">BuildVis is an innovative platform that combines 3D modeling, AI-driven budgeting, and e-commerce platform to simplify construction planning.</p>
                                    </div>
                                </div>
                                <span class="flex-shrink-0">
                                    <div :class="{ 'hidden': accordion }">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 5.69995V18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M5.69995 12H18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                    <div :class="{ 'hidden': !accordion }" class="hidden">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.69995 12H18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </span>
                            </button>
                            <button x-data="{ accordion: false }" x-on:click.prevent="accordion = !accordion" class="flex w-full py-6 px-8 mb-4 items-start justify-between text-left bg-white shadow-md rounded-2xl">
                                <div class="pr-5">
                                    <h5 class="text-lg font-medium">Who can use BuildVis?</h5>
                                    <div x-ref="container" :style="accordion ? 'height: ' + $refs.container.scrollHeight + 'px' : ''" class="overflow-hidden h-0 duration-500">
                                        <p class="text-gray-700 mt-4">BuildVis is designed for everyone—homeowners, architects, contractors, and DIYers. Whether you’re planning a small renovation or a large-scale construction project, BuildVis has the tools to help.</p>
                                    </div>
                                </div>
                                <span class="flex-shrink-0">
                                    <div :class="{ 'hidden': accordion }">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 5.69995V18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M5.69995 12H18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                    <div :class="{ 'hidden': !accordion }" class="hidden">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.69995 12H18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </span>
                            </button>
                            <button x-data="{ accordion: false }" x-on:click.prevent="accordion = !accordion" class="flex w-full py-6 px-8 mb-4 items-start justify-between text-left bg-white shadow-md rounded-2xl">
                                <div class="pr-5">
                                    <h5 class="text-lg font-medium">Can I adjust my budget in real time?</h5>
                                    <div x-ref="container" :style="accordion ? 'height: ' + $refs.container.scrollHeight + 'px' : ''" class="overflow-hidden h-0 duration-500">
                                        <p class="text-gray-700 mt-4">Yes! BuildVis lets you input your budget and instantly see how changes affect material selection and costs. You can tweak your budget and watch the 3D model update in real time.</p>
                                    </div>
                                </div>
                                <span class="flex-shrink-0">
                                    <div :class="{ 'hidden': accordion }">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 5.69995V18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M5.69995 12H18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                    <div :class="{ 'hidden': !accordion }" class="hidden">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.69995 12H18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </span>
                            </button>
                            <button x-data="{ accordion: false }" x-on:click.prevent="accordion = !accordion" class="flex w-full py-6 px-8 mb-4 items-start justify-between text-left bg-white shadow-md rounded-2xl">
                                <div class="pr-5">
                                    <h5 class="text-lg font-medium">Can I check material availability?</h5>
                                    <div x-ref="container" :style="accordion ? 'height: ' + $refs.container.scrollHeight + 'px' : ''" class="overflow-hidden h-0 duration-500">
                                        <p class="text-gray-700 mt-4">Yes, BuildVis syncs with real-time inventory to ensure suggested materials are in stock. If an item is unavailable, you’ll be notified immediately.</p>
                                    </div>
                                </div>
                                <span class="flex-shrink-0">
                                    <div :class="{ 'hidden': accordion }">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 5.69995V18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M5.69995 12H18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                    <div :class="{ 'hidden': !accordion }" class="hidden">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.69995 12H18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </span>
                            </button>
                            <button x-data="{ accordion: false }" x-on:click.prevent="accordion = !accordion" class="flex w-full py-6 px-8 mb-4 items-start justify-between text-left bg-white shadow-md rounded-2xl">
                                <div class="pr-5">
                                    <h5 class="text-lg font-medium">Can I use BuildVis on my phone?</h5>
                                    <div x-ref="container" :style="accordion ? 'height: ' + $refs.container.scrollHeight + 'px' : ''" class="overflow-hidden h-0 duration-500">
                                        <p class="text-gray-700 mt-4">Yes! BuildVis is fully responsive and works on both desktop and mobile devices. We also offer a mobile app for a seamless experience.</p>
                                    </div>
                                </div>
                                <span class="flex-shrink-0">
                                    <div :class="{ 'hidden': accordion }">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 5.69995V18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M5.69995 12H18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                    <div :class="{ 'hidden': !accordion }" class="hidden">
                                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.69995 12H18.3" stroke="#1D1F1E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 lg:py-24 overflow-hidden" x-data="{ activeSlide: 1, slideCount: 3 }">
        <div class="container mx-auto px-4">
            <div class="max-w-xs sm:max-w-md md:max-w-none mx-auto text-center mb-20">
                <h1 class="font-heading text-5xl sm:text-6xl tracking-tight mb-6">What our customers say</h1>
                <p class="text-gray-700">Thousands of happy customers that changed their energy use </p>
            </div>
            <div class="max-w-md md:max-w-2xl lg:max-w-6xl mx-auto">
                <div class="flex flex-wrap items-center justify-center md:justify-between -mx-4">
                    <div class="px-4 order-last md:order-first">
                        <a href="#" x-on:click.prevent="activeSlide = activeSlide &gt; 1 ? activeSlide - 1 : slideCount" class="inline-block mr-4 text-gray-700 hover:text-lime-500">
                            <svg width="32" height="32" viewbox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24.4 16H7.59998" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16 24.4L7.59998 16L16 7.59998" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="w-full md:w-2/3 lg:w-auto px-4 mb-12 md:mb-0">
                        <div class="relative px-6">
                            <div class="absolute top-1/2 left-0 transform -translate-y-1/2 h-full w-full py-8">
                                <div class="h-full bg-gray-50 bg-opacity-70 shadow-md rounded-2xl"></div>
                            </div>
                            <div class="relative py-12 px-16 text-center bg-white shadow-md rounded-2xl">
                                <div class="max-w-2xl mx-auto">
                                    <div class="mb-4 inline-block mx-auto">
                                        <svg width="120" height="24" viewbox="0 0 120 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.1033 4.81663C11.4701 4.07346 12.5299 4.07346 12.8967 4.81663L14.5486 8.16309C14.6941 8.45794 14.9753 8.6624 15.3006 8.70995L18.9962 9.25012C19.8161 9.36996 20.1429 10.3778 19.5493 10.956L16.8768 13.559C16.6409 13.7887 16.5333 14.1199 16.5889 14.4444L17.2194 18.1206C17.3595 18.9376 16.502 19.5606 15.7684 19.1747L12.4655 17.4378C12.1741 17.2845 11.8259 17.2845 11.5345 17.4378L8.23163 19.1747C7.498 19.5606 6.64045 18.9376 6.78057 18.1206L7.41109 14.4444C7.46675 14.1199 7.35908 13.7887 7.12321 13.559L4.45068 10.956C3.85709 10.3778 4.18387 9.36996 5.00378 9.25012L8.69937 8.70995C9.02472 8.6624 9.30591 8.45794 9.45145 8.16309L11.1033 4.81663Z"
                                                fill="#BEF264"></path>
                                            <path
                                                d="M35.1033 4.81663C35.4701 4.07346 36.5299 4.07346 36.8967 4.81663L38.5486 8.16309C38.6941 8.45794 38.9753 8.6624 39.3006 8.70995L42.9962 9.25012C43.8161 9.36996 44.1429 10.3778 43.5493 10.956L40.8768 13.559C40.6409 13.7887 40.5333 14.1199 40.5889 14.4444L41.2194 18.1206C41.3595 18.9376 40.502 19.5606 39.7684 19.1747L36.4655 17.4378C36.1741 17.2845 35.8259 17.2845 35.5345 17.4378L32.2316 19.1747C31.498 19.5606 30.6405 18.9376 30.7806 18.1206L31.4111 14.4444C31.4667 14.1199 31.3591 13.7887 31.1232 13.559L28.4507 10.956C27.8571 10.3778 28.1839 9.36996 29.0038 9.25012L32.6994 8.70995C33.0247 8.6624 33.3059 8.45794 33.4514 8.16309L35.1033 4.81663Z"
                                                fill="#BEF264"></path>
                                            <path
                                                d="M59.1033 4.81663C59.4701 4.07346 60.5299 4.07346 60.8967 4.81663L62.5486 8.16309C62.6941 8.45794 62.9753 8.6624 63.3006 8.70995L66.9962 9.25012C67.8161 9.36996 68.1429 10.3778 67.5493 10.956L64.8768 13.559C64.6409 13.7887 64.5333 14.1199 64.5889 14.4444L65.2194 18.1206C65.3595 18.9376 64.502 19.5606 63.7684 19.1747L60.4655 17.4378C60.1741 17.2845 59.8259 17.2845 59.5345 17.4378L56.2316 19.1747C55.498 19.5606 54.6405 18.9376 54.7806 18.1206L55.4111 14.4444C55.4667 14.1199 55.3591 13.7887 55.1232 13.559L52.4507 10.956C51.8571 10.3778 52.1839 9.36996 53.0038 9.25012L56.6994 8.70995C57.0247 8.6624 57.3059 8.45794 57.4514 8.16309L59.1033 4.81663Z"
                                                fill="#BEF264"></path>
                                            <path
                                                d="M83.1033 4.81663C83.4701 4.07346 84.5299 4.07346 84.8967 4.81663L86.5486 8.16309C86.6941 8.45794 86.9753 8.6624 87.3006 8.70995L90.9962 9.25012C91.8161 9.36996 92.1429 10.3778 91.5493 10.956L88.8768 13.559C88.6409 13.7887 88.5333 14.1199 88.5889 14.4444L89.2194 18.1206C89.3595 18.9376 88.502 19.5606 87.7684 19.1747L84.4655 17.4378C84.1741 17.2845 83.8259 17.2845 83.5345 17.4378L80.2316 19.1747C79.498 19.5606 78.6405 18.9376 78.7806 18.1206L79.4111 14.4444C79.4667 14.1199 79.3591 13.7887 79.1232 13.559L76.4507 10.956C75.8571 10.3778 76.1839 9.36996 77.0038 9.25012L80.6994 8.70995C81.0247 8.6624 81.3059 8.45794 81.4514 8.16309L83.1033 4.81663Z"
                                                fill="#BEF264"></path>
                                            <path
                                                d="M107.103 4.81663C107.47 4.07346 108.53 4.07346 108.897 4.81663L110.549 8.16309C110.694 8.45794 110.975 8.6624 111.301 8.70995L114.996 9.25012C115.816 9.36996 116.143 10.3778 115.549 10.956L112.877 13.559C112.641 13.7887 112.533 14.1199 112.589 14.4444L113.219 18.1206C113.36 18.9376 112.502 19.5606 111.768 19.1747L108.465 17.4378C108.174 17.2845 107.826 17.2845 107.535 17.4378L104.232 19.1747C103.498 19.5606 102.64 18.9376 102.781 18.1206L103.411 14.4444C103.467 14.1199 103.359 13.7887 103.123 13.559L100.451 10.956C99.8571 10.3778 100.184 9.36996 101.004 9.25012L104.699 8.70995C105.025 8.6624 105.306 8.45794 105.451 8.16309L107.103 4.81663Z"
                                                fill="#BEF264"></path>
                                        </svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div :style="'transform: translateX(-' + (activeSlide - 1) * 100 + '%)'" class="flex -mx-4 transition-transform duration-500">
                                            <div class="flex-shrink-0 px-4 w-full">
                                                <h4 class="text-2xl lg:text-3xl font-medium mb-10">"BuildVis completely changed the way I approached building my dream home. The 3D modeling feature let me see exactly how everything would look, and the budget tool saved me thousands by suggesting affordable alternatives."</h4>
                                                <span class="block text-xl font-medium">Jenny Wilson</span>
                                                <span class="block text-lg text-gray-700">Homeowner</span>
                                            </div>
                                            <div class="flex-shrink-0 px-4 w-full">
                                                <h4 class="text-2xl lg:text-3xl font-medium mb-10">"I’ve always wanted to build my own shed, but I didn’t know where to start. BuildVis made it so easy—I could play around with designs, stay within my budget, and even order materials directly from the platform. It’s like having a construction expert in your pocket!"</h4>
                                                <span class="block text-xl font-medium">Mary Jane</span>
                                                <span class="block text-lg text-gray-700">DIY Enthusiast</span>
                                            </div>
                                            <div class="flex-shrink-0 px-4 w-full">
                                                <h4 class="text-2xl lg:text-3xl font-medium mb-10">"BuildVis completely changed the way I approached building my dream home. The 3D modeling feature let me see exactly how everything would look, and the budget tool saved me thousands by suggesting affordable alternatives."</h4>
                                                <span class="block text-xl font-medium">Anastasia Relo</span>
                                                <span class="block text-lg text-gray-700">Customer</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 order-last">
                        <a href="#" x-on:click.prevent="activeSlide = activeSlide &lt; slideCount ? activeSlide + 1 : 1" class="inline-block text-gray-700 hover:text-lime-500">
                            <svg width="32" height="32" viewbox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.59998 16H24.4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16 7.59998L24.4 16L16 24.4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="p-4">
            <div class="max-w-xl lg:max-w-5xl mx-auto xl:max-w-none px-5 md:px-12 xl:px-24 py-16 bg-teal-900 rounded-2xl">
                <div class="container mx-auto px-4">
                    <div class="flex flex-wrap items-center -mx-4">
                        <div class="w-full lg:w-2/3 px-4 mb-8 lg:mb-0">
                            <div class="max-w-md xl:max-w-none">
                                <h1 class="font-heading text-4xl xs:text-5xl sm:text-6xl tracking-sm text-white mb-6">Find Affordable Materials</h1>
                                <p class="text-lg text-white opacity-80">Our commitment to green energy is paving the way for a cleaner, healthier planet. </p>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/3 px-4 lg:text-right">
                            <a href="#" class="inline-flex py-4 px-6 items-center justify-center text-lg font-medium text-teal-900 border border-lime-500 hover:border-white bg-lime-500 hover:bg-white rounded-full transition duration-200">Start Building</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 lg:py-24 relative overflow-hidden">
        <img class="absolute top-0 left-0 w-full h-full" src="flow-assets/contact/waves-bg-light.png" alt="">
        <div class="container mx-auto px-4 relative">
            <div class="max-w-lg mx-auto md:max-w-none">
                <div class="flex flex-wrap -mx-4 mb-16">
                    <div class="w-full md:w-1/2 px-4 mb-12 md:mb-0">
                        <h1 class="font-heading text-4xl sm:text-6xl md:text-7xl tracking-sm mb-6">Contact us</h1>
                        <p class="text-lg text-gray-700">From Questions to Quotations—We’re Here for You!</p>
                    </div>
                    <div class="w-full md:w-1/2 px-4">
                        <div class="max-w-md lg:max-w-sm lg:ml-auto">
                            <div class="mb-8 p-8 bg-white border rounded-2xl">
                                <div class="flex items-center mb-8">
                                    <svg width="48" height="48" viewbox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 8C0 3.58172 3.58172 0 8 0H40C44.4183 0 48 3.58172 48 8V40C48 44.4183 44.4183 48 40 48H8C3.58172 48 0 44.4183 0 40V8Z" fill="#BEF264"></path>
                                        <path d="M11.5389 13.4152L24 23.6106L36.461 13.4152C36.3173 13.3623 36.162 13.3333 36 13.3333H12C11.8379 13.3333 11.6826 13.3623 11.5389 13.4152Z" fill="#022C22"></path>
                                        <path d="M10.6666 16.147V33.3333C10.6666 34.0697 11.2636 34.6667 12 34.6667H36C36.7363 34.6667 37.3333 34.0697 37.3333 33.3333V16.147L24.8443 26.3653C24.3531 26.7671 23.6468 26.7671 23.1556 26.3653L10.6666 16.147Z" fill="#022C22"></path>
                                    </svg>
                                    <span class="block ml-4 text-2xl font-medium">Email</span>
                                </div>
                                <p class="mt-8 text-lg font-medium">support@buildvis.com</p>
                            </div>
                            <div class="mb-8 p-8 bg-white border rounded-2xl">
                                <div class="flex items-center mb-8">
                                    <svg width="48" height="48" viewbox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 8C0 3.58172 3.58172 0 8 0H40C44.4183 0 48 3.58172 48 8V40C48 44.4183 44.4183 48 40 48H8C3.58172 48 0 44.4183 0 40V8Z" fill="#BEF264"></path>
                                        <path d="M13.3333 12C12.597 12 12 12.597 12 13.3333C12 25.8518 22.1482 36 34.6667 36C35.403 36 36 35.403 36 34.6667V28.2667C36 27.6779 35.6138 27.1588 35.0498 26.9896L29.7165 25.3896C29.2466 25.2486 28.7374 25.377 28.3905 25.7239L26.8288 27.2856C24.2738 25.847 22.153 23.7262 20.7144 21.1712L22.2761 19.6095C22.623 19.2626 22.7514 18.7534 22.6104 18.2835L21.0104 12.9502C20.8412 12.3862 20.3221 12 19.7333 12H13.3333Z" fill="#022C22"></path>
                                    </svg>
                                    <span class="block ml-4 text-2xl font-medium">Phone</span>
                                </div>
                                <p class="mt-8 text-lg font-medium">+639000000000</p>
                            </div>
                            <div class="p-8 bg-white border rounded-2xl">
                                <div class="flex items-center mb-8">
                                    <svg width="48" height="48" viewbox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 8C0 3.58172 3.58172 0 8 0H40C44.4183 0 48 3.58172 48 8V40C48 44.4183 44.4183 48 40 48H8C3.58172 48 0 44.4183 0 40V8Z" fill="#BEF264"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M24.7885 37.0752L24.79 37.074L24.7925 37.0722L24.7999 37.0668L24.8246 37.0484C24.8455 37.0328 24.8749 37.0106 24.9124 36.9821C24.9874 36.925 25.0947 36.8422 25.2296 36.7352C25.4993 36.5212 25.8801 36.2099 26.3352 35.8126C27.2434 35.0197 28.4567 33.876 29.6736 32.4735C32.0636 29.7193 34.6666 25.7403 34.6666 21.3334C34.6666 15.4423 29.891 10.6667 23.9999 10.6667C18.1089 10.6667 13.3333 15.4423 13.3333 21.3334C13.3333 25.7403 15.9363 29.7193 18.3262 32.4735C19.5432 33.876 20.7564 35.0197 21.6647 35.8126C22.1197 36.2099 22.5006 36.5212 22.7702 36.7352C22.9051 36.8422 23.0124 36.925 23.0874 36.9821C23.1249 37.0106 23.1544 37.0328 23.1752 37.0484L23.2 37.0668L23.2074 37.0722L23.2107 37.0747C23.68 37.4189 24.3191 37.4194 24.7885 37.0752ZM23.997 24.6667C25.8379 24.6667 27.3303 23.1743 27.3303 21.3334C27.3303 19.4924 25.8379 18 23.997 18C22.156 18 20.6637 19.4924 20.6637 21.3334C20.6637 23.1743 22.156 24.6667 23.997 24.6667Z"
                                            fill="#022C22"></path>
                                    </svg>
                                    <span class="block ml-4 text-2xl font-medium">Main Office</span>
                                </div>
                                <p class="mt-8 text-lg font-medium">Victoria, Oriental Mindoro 5205 Philippines</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative py-12 lg:py-24 bg-teal-900 overflow-hidden">
        <img class="absolute bottom-0 left-0" src="flow-assets/footer/waves-lines-left-bottom.png" alt="">
        <div class="container px-4 mx-auto relative">
            <div class="max-w-xl lg:max-w-none mx-auto">
                <div class="flex flex-wrap mb-12 lg:mb-24 -mx-4">
                    <div class="w-full lg:w-1/2 px-4 mb-16 lg:mb-0">
                        <a class="inline-block mb-18" href="#">
                            <img src="images/logo-transparent.png" alt="" class="h-28">
                        </a>

                    </div>
                    <div class="w-full lg:w-1/2 px-4">
                        <div class="flex flex-wrap -mx-4">
                            <div class="w-1/2 xs:w-1/3 px-4 mb-8 xs:mb-0">
                                <h3 class="mb-6 text-white font-bold">Platform</h3>
                                <ul>
                                    <li class="mb-4">
                                    </li>
                                    <li class="mb-4"><a class="inline-block text-white opacity-80 hover:opacity-100 font-medium" href="#">How it works</a></li>
                                    <li><a class="inline-block text-white opacity-80 hover:opacity-100 font-medium" href="#">Pricing</a></li>
                                </ul>
                            </div>
                            <div class="w-1/2 xs:w-1/3 px-4 mb-8 xs:mb-0">
                                <h3 class="mb-6 text-white font-bold">Resources</h3>
                                <ul>
                                    <li class="mb-4"><a class="inline-block text-white opacity-80 hover:opacity-100 font-medium" href="#">Download App</a></li>
                                    <li class="mb-4"><a class="inline-block text-white opacity-80 hover:opacity-100 font-medium" href="#">Help Center</a></li>
                                    <li><a class="inline-block text-white opacity-80 hover:opacity-100 font-medium" href="#">Support</a></li>
                                </ul>
                            </div>
                            <div class="w-full xs:w-1/3 px-4">
                                <h3 class="mb-6 text-white font-bold">Company</h3>
                                <ul>
                                    <li class="mb-4"><a class="inline-block text-white opacity-80 hover:opacity-100 font-medium" href="#">About</a></li>
                                    <li class="mb-4"><a class="inline-block text-white opacity-80 hover:opacity-100 font-medium" href="#">Our Mission</a></li>
                                    <li class="mb-4">
                                    </li>
                                    <li><a class="inline-block text-white opacity-80 hover:opacity-100 font-medium" href="#">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-white text-right">©{{ today()->year }} BuildVis. All rights reserved.</p>
                </div>
            </div>
        </div>
    </section>
</div>
