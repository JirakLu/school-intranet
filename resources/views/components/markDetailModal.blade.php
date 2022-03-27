<!-- This example requires Tailwind CSS v2.0+ -->
<div x-show="markDetailModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
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
        <div x-show="markDetailModal"
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
        <div x-show="markDetailModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             @click.outside="markDetailModal = false"
             class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:p-6">
            <h3 class="text-2xl font-normal">
                Detail známky
            </h3>
            <div class="flex flex-col divide-gray-300 divide-y-2">
                <div class="flex flex-col md:flex-row gap-3 mt-3 justify-between py-5 px-5">
                    <div class="flex items-center gap-3">
                        <h3 class="text-gray-600 font-semibold text-sm">Známka</h3>
                        <p x-text="markDetailData.mark" class="text-lg font-bold"></p>
                    </div>
                    <div class="flex items-center gap-3">
                        <h3 class="text-gray-600 font-semibold text-sm">Váha</h3>
                        <p x-text="markDetailData.weight" class="text-lg font-bold"></p>
                    </div>
                </div>
                <div class="flex flex-col gap-1 py-5 px-5">
                    <h3 class="text-gray-600 font-semibold text-sm">Látka</h3>
                    <p x-text="markDetailData.sub_type" class="text-sm font-normal"></p>
                </div>
                <div class="flex flex-col gap-1 py-5 px-5">
                    <h3 class="text-gray-600 font-semibold text-sm">Učitel</h3>
                    <p x-text="markDetailData.teacher" class="text-sm font-normal"></p>
                </div>
                <div class="flex flex-col gap-1 py-5 px-5">
                    <h3 class="text-gray-600 font-semibold text-sm">Kategorie</h3>
                    <p x-text="markDetailData.category" class="text-sm font-normal"></p>
                </div>
                <div class="flex flex-col gap-1 py-5 px-5">
                    <h3 class="text-gray-600 font-semibold text-sm">Poznámka</h3>
                    <p x-text="markDetailData.desc ? markDetailData.desc : 'Nejsou žádné poznámky'" class="text-sm font-normal"></p>
                </div>
                <div class="flex flex-row justify-between items-center">
                    <h3 x-text="markDetailData.date" class="text-gray-800 font-thin text-sm py-5"></h3>
                    <!-- Heroicon name: solid/exclamation -->
                    <svg class="cursor-pointer h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20"
                         fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                              clip-rule="evenodd"/>
                    </svg>

                </div>
            </div>
        </div>
    </div>
</div>
