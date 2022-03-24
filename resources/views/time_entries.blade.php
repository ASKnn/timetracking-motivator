<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All users list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-row">
                <div class="flex flex-row space-x-4 text-sm font-bold leading-6">
                <?php

                    foreach ($groupedEntries as $userId => $entries) {
                        if(isset($userResources[$userId])) {
                            $timeHours = 0;
                            /** @var \App\Models\RedmineUsers $user */
                            $user = $userResources[$userId];
                            foreach ($entries as $entry) {
                                $timeHours += floatval($entry['hours']);
                            }
                            ?>

                        <div class="basis-1/4 h-14 rounded-lg flex items-center justify-center bg-amber-600 shadow-lg">
                            This is user {!! $user->surname !!}, {!! $timeHours !!}</div>
                        <?php
                        }
                    }
                    ?>

                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
