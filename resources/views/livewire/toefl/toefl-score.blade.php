<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sections</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Dikerjakan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Benar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Listening Comprehension</td>
                            <td class="px-6 py-3 text-left text-xs font-medium tracking-wider">
                                <span class="px-2 inline-flex text-right text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $score->section1_answered }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-left text-xs font-medium tracking-wider">
                                <span class="px-2 inline-flex text-right text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $score->section1_correct }}
                                </span>
                            </td class="px-6 py-3 text-left text-xs font-medium tracking-wider">
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Structure and Written Expression</td>
                            <td class="px-6 py-3 text-left text-xs font-medium tracking-wider">
                                <span class="px-2 inline-flex text-right text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $score->section2_answered }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-left text-xs font-medium tracking-wider">
                                <span class="px-2 inline-flex text-right text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $score->section2_correct }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Reading Comprehension</td>
                            <td class="px-6 py-3 text-left text-xs font-medium tracking-wider">
                                <span class="px-2 inline-flex text-right text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $score->section3_answered }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-left text-xs font-medium tracking-wider">
                                <span class="px-2 inline-flex text-right text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $score->section3_correct }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">FINAL SCORE</td>
                            <td class="px-6 py-3 text-left text-xs font-medium tracking-wider">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $score->final_score }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>