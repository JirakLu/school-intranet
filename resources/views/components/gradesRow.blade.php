<div class="flex flex-col md:flex-row w-full divide-gray-500 divide-y-[1px] md:divide-x-[1px] md:divide-y-0">
    <div class="flex place-items-center bg-indigo-100 px-2 py-1 w-full max-w-[180px]">
        <p class="text-sm md:text-base font-medium text-indigo-800">{{$subjectName}}</p>
    </div>
    <div class="flex flex-row gap-2 flex-wrap w-full px-4 py-2 items-center bg-gray-50">
        @foreach($markInfo as $mark)
            <div x-data="{
                    markInfo: {
                        mark: '{{$mark->getMark()}}',
                        weight: '{{$mark->getWeight()}}',
                        sub_type: '{{$mark->getLatka()}}',
                        teacher: '{{$mark->getTeachersName()}}',
                        category: '{{$mark->getLabel()}}',
                        desc: '{{$mark->getDescription()}}',
                        date: '{{$mark->getDate()}}'
                    }
                }"
                 @click="markDetailModal = true; markDetailData = markInfo"
                 class="w-6 h-6 rounded-md text-black grid place-items-center cursor-pointer"
                 style="background:{{$mark->getColor()}}"
            >


                <p>{{$mark->getMark()}}</p>
            </div>
        @endforeach
    </div>
    <div class="flex place-items-center bg-gray-200 px-4 py-1 flex-row min-w-[80px] max-w-[80px] gap-1">
        <p class="text-sm md:text-lg font-medium text-gray-800 ">{{round(calculateAverage($markInfo))}}</p>
        <span> - </span>
        <p class="text-base text-gray-500">{{calculateAverage($markInfo)}}</p>
    </div>
</div>