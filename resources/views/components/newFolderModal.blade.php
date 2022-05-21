<!-- This example requires Tailwind CSS v2.0+ -->
<div x-show="newFolderModal" x-bind:class="newFolderModal ? '!block' : 'hidden'" class="fixed z-10 inset-0 overflow-y-auto overscroll-contain hidden"
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
        <div x-show="newFolderModal"
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
        <div x-show="newFolderModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             @click.outside="newFolderModal = false"
             class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left shadow-xl transform transition-all sm:my-8 sm:align-middle w-[350px] sm:max-w-md sm:p-6">
            <h3 class="text-2xl font-normal mb-5">
                Vytvořit novou složku
            </h3>

            <form method="POST" action="{{$createLink("api/files/createFolder")}}" class="space-y-2">
                <input type="text" name="parent" id="parent" x-bind:value="window.location.href.split('/').pop() !== 'files' ? window.location.href.split('/').pop() : ''" class="hidden">
                <input type="text" name="backURL" id="backURL" x-bind:value="window.location.href" class="hidden">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Název: </label>
                    <input type="text" name="name" id="name" required pattern='^[^\s^\x00-\x1f\\?*:"";<>|\/.][^\x00-\x1f\\?*:"";<>|\/]*[^\s^\x00-\x1f\\?*:"";<>|\/.]+$' title="No ani se o to nepokoušej :))"
                           class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">

                </div>

                <legend class="sr-only">Private</legend>
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input id="private" aria-describedby="private" name="private" type="checkbox" value="private" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="private" class="font-medium text-gray-700">Privátní</label>
                        <span id="private" class="text-gray-500">Složku uvidíte pouze vy a nikdo jiný.</span>
                    </div>
                </div>

                <button type="submit"
                        class="inline-flex !mt-4 w-full justify-center items-center px-4 py-2 border border-transparent shadow-sm cursor-pointer text-base font-medium rounded-md bg-green-100 hover:bg-green-200 text-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 border border-green-500">
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
