<aside id="sidebar-multi-level-sidebar"
       class="top-0 left-0 z-40 w-1/6"
       aria-label="Sidebar">
    @if (isset($header))
        <div class="bg-white dark:bg-gray-800 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    @endif
    <div class="min-h-screen px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <ul class="space-y-2">
            <li>
                <a href="#"
                   class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg aria-hidden="true"
                         class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">{{__('Orders')}}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
