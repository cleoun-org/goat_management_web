<div class="flex">
    <a class="btn btn-outline-secondary w-1/2 sm:w-auto mr-1" target="_blank_" href="{{route("ds.report.preview.pdf", ['username' => isset($username) ? $username : "", "report_model" => $report_model])}}"> <i
        data-feather="printer" class="w-4 h-4 mr-2"></i></a>
    <div class="dropdown w-1/2 sm:w-auto">
        <button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto"  aria-expanded="false">
            <i data-feather="file-text" class="w-4 h-4 mr-2"></i> <i data-feather="chevron-down"
                class="w-4 h-4 ml-auto sm:ml-2"></i> </button>
        <div class="dropdown-menu w-40">
            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                <a id="tabulator-export-json" target="_blank_" href="{{ route('ds.report.export.pdf', ['username' => isset($username) ? $username : "", "report_model" => $report_model]) }}"
                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                    <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export PDF
                </a>
            </div>
        </div>
    </div>
</div>