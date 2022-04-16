<!-- This example requires Tailwind CSS v2.0+ -->
<div x-show="addCategoryModal" class="fixed z-10 inset-0 overflow-y-auto overscroll-contain"
     aria-labelledby="modal-title"
     role="dialog"
     aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!--
          Background overlay, show/hide based on modal state.

          Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div x-show="addCategoryModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!--
          Modal panel, show/hide based on modal state.

          Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        -->
        <div x-show="addCategoryModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             @click.outside="addCategoryModal = false"
             class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left shadow-xl transform transition-all sm:my-8 sm:align-middle w-[350px] sm:max-w-md sm:p-6">
            <h3 class="text-2xl font-normal mb-5">
                Přidat kategorii
            </h3>

            <form method="POST" action="{{$createLink("api/category/addCategory")}}" class="space-y-2">
                <input type="text" name="backURL" id="backURL" x-bind:value="window.location.href" class="hidden">
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700">Váha: </label>
                    <div class="mt-1">
                        <input type="number" min="0" max="10" name="weight" id="weight" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700">Barvička: </label>
                    <div class="mt-1">
                        <input type="color" name="color" id="color" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-12 px-2 sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700">Látka: </label>
                    <div class="mt-1">
                        <textarea rows="1" name="label" id="label" required
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                </div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm cursor-pointer text-base font-medium rounded-md bg-green-100 hover:bg-green-200 text-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 border border-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-3 h-5 w-5 text-green-500" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Přidat
                </button>

            </form>

        </div>
    </div>
</div>
