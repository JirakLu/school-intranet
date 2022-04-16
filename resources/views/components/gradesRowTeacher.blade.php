<div class="flex flex-col md:flex-row w-full divide-gray-500 divide-y-[1px] md:divide-x-[1px] md:divide-y-0">
    <div class="flex place-items-center bg-indigo-100 px-2 py-1 w-full max-w-[180px]">
        <p class="text-sm md:text-base font-medium text-indigo-800">{{$markInfo["studentName"]}}</p>
    </div>
    <div class="flex flex-row gap-2 flex-wrap w-full px-4 py-2 items-center bg-gray-100">
        @foreach($markInfo["marks"] as $mark)
            <div x-data="{
                    markInfo: {
                        mark: '{{$mark->getMtMark()}}',
                        markID: '{{$mark->getMarkID()}}',
                        markTypeID: '{{$mark->getMarkTypeID()}}',
                        markWeight: '{{$mark->getMcWeight()}}',
                        latka: '{{$mark->getLatka()}}',
                        subjectName: '{{$mark->getSubjectName()}}',
                        teacher: '{{$mark->getTeachersName()}}',
                        markCategoryID: '{{$mark->getMarkCategoryID()}}',
                        markCategory: '{{$mark->getMcLabel()}}',
                        markDesc: '{{$mark->getMarkDesc()}}',
                        date: '{{$mark->getDate()}}',
                    }
                }"
                 @click="markDetailModal = true; markDetailData = markInfo"
                 class="w-6 h-6 rounded-md text-black grid place-items-center cursor-pointer"
                 style="background:{{$mark->getMcColor()}}"
            >
                <p>{{$mark->getMtMark()}}</p>
            </div>
        @endforeach
        @if($addMark)
            <div @click="markAddModal = true;
            markAddData = {
                courseID: '{{$markInfo["courseID"]}}',
                studentID: '{{$markInfo["studentID"]}}'
            }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer text-green-500" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        @endif
    </div>
    <div class="flex place-items-center bg-gray-200 px-4 py-1 flex-row min-w-[80px] max-w-[80px] gap-1">
        <p class="text-sm md:text-lg font-medium text-gray-800 ">{{$markInfo["averageRounded"]}}</p>
        <span> - </span>
        <p class="text-base text-gray-500">{{$markInfo["average"]}}</p>
    </div>
</div>