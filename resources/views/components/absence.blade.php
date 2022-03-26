@if($excused)
    <a href="{{$createLink("absence")}}" class="px-4 py-3 bg-white shadow rounded-mb bg-green-50 flex flex-row justify-between items-center cursor-pointer hover:bg-green-100">
        <p class="text-sm font-medium text-green-800">10.2.2022 - 10.2.2022</p>
        <p class="text-sm font-medium text-green-800">8 hodin</p>
        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"/>
        </svg>
    </a>
@else
    <a href="{{$createLink("absence")}}" class="px-4 py-3 bg-white shadow rounded-mb bg-red-50 flex flex-row justify-between items-center cursor-pointer hover:bg-red-100">
        <p class="text-sm font-medium text-red-400">15.3.2022 - 15.3.2022</p>
        <p class="text-sm font-medium text-red-400">3 hodiny</p>
        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
             aria-hidden="true">
            <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                  clip-rule="evenodd"/>
        </svg>
    </a>
@endif

