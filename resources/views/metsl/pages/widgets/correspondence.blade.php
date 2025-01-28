<div class="widget" id="widget-correspondence">
    <h2 class="bg-blue-500 text-md inline-flex uppercase text-white font-semibold px-4 py-2 rounded-t-lg w-fit">
        <i data-feather="repeat" class="me-2 text-blue-700"></i>Correspondence
    </h2>
    <div class="overflow-x-auto border border-blue-500 rounded-tl-none rounded-xl">
        <table class="rounded-tl-none min-w-full">
            <thead class="bg-blue-200 dark:bg-blue-500/25 text-sm text-left">
                <tr>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Number</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Subject</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Created by</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Created at</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Status</th>
                </tr>
            </thead>
            <tbody id="widget-correspondence-table">
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
    </div>
</div>

<script>

function loadWidgetCorrespondence() {
    const fragment = document.createDocumentFragment();
    const widgetCorrespondenceTable = document.getElementById('widget-correspondence-table');
    
    if(correspondenceData.length > 0){
        
        for (let i = 0; i < correspondenceData.length; i++) {
            
                const row = correspondenceData[i];
                const tr = document.createElement('tr');
                tr.classList.add('border-b','dark:border-gray-800','hover:shadow-lg','hover:bg-gray-100','hover:dark:bg-gray-700' , `corespondence_row${i}`);
                let url = "{{ route('projects.correspondence.view', [':id']) }}".replace(':id', row.id);
                let url2 = "{{ route('projects.correspondence.edit', [':id']) }}".replace(':id', row.id);

                tr.innerHTML = `
                    <td class="px-2 py-2 lg:px-4 lg:py-2">${row.number}</td>
                    <td class="px-2 py-2 lg:px-4 lg:py-2"><a class="underline" href="${url}">${row.subject}</a></td>
                    <td class="px-2 py-2 lg:px-4 lg:py-2">${(row.created_by != null) ? row.created_by.name : ''}</td>
                    <td class="px-2 py-2 lg:px-4 lg:py-2">${row.created_date}</td>
                    <td class="px-2 py-2 lg:px-4 lg:py-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold ${row.status_color[1]}">${row.status_color[0]}</span>
                    </td>
                `;

                fragment.appendChild(tr);
                allDataLength = allDataLength - 1;
        }
    }else{
        widgetCorrespondenceTable.innerHTML='';
    }
    widgetCorrespondenceTable.innerHTML='';

    widgetCorrespondenceTable.appendChild(fragment);
    loadedRows += rowsToLoad;
}

</script>