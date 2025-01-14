import $ from 'jquery';
import './bootstrap';
import feather from 'feather-icons';
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/silver/theme';

import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.min.css';

window.$ = $;
window.feather = feather;

$(document).ready(function() {
    getLocalStorage();
    feather.replace({ 'stroke-width': 1 });

    $('.tab-links button').click(function() {
        // Remove .active class from all buttons
        let tablinks = $(this).closest('.tab-links');
        tablinks.find('button').removeClass('active');
        
        // Add .active class to the clicked button
        $(this).addClass('active');

        console.log($(this).closest('.dropdown'));
        $(this).closest('.dropdown').toggleClass('hidden');
        $(this).closest('.has-dropdown').find('.current-selected').text($(this).text());
        // Hide all tab contents
        $(`.tab-view[data-tabs=${tablinks.data('tabs')}] .tab-content`).addClass('hidden');

        // Show the target tab content
        let target = $(this).data('tab');
        console.log(target);
        $(`.tab-content#${target}`).removeClass('hidden');
    });

    
    $(document).on('click', 'button.dropdown-toggle', function(){
        $(this).closest('.has-dropdown').find('.dropdown').toggleClass('hidden');
    });

    $(document).on('click', 'button.modal-toggler', function(){
        let modal_name = $(this).data('modal');
        $(`#${modal_name}`).toggleClass('hidden');
    });

    tinymce.init({
        selector: 'textarea', // Select all textarea tags
        plugins: 'link lists',
        toolbar: 'undo redo | bold italic | bullist numlist | link',
        menubar: false,
        height: 300, // Set height
        branding: false, // Hide branding
        base_url: '/tinymce', // Path to TinyMCE assets
        suffix: '.min', // Ensure minified files are used
        skin: 'oxide-dark', // Use the dark theme
        content_css: 'dark', // Use the dark mode content CSS
    });
});

const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('file-upload');
const fileInputEdit = document.getElementById('file-upload-edit');
const dropZoneEdit = document.getElementById('drop-zone-edit');

const fileList = document.getElementById('file-list');
const fileListEdit = document.getElementById('file-list-edit');

// Handle drag events
dropZone.addEventListener('dragover', (event) => {
    event.preventDefault(); // Prevent default behavior
    dropZone.classList.add('bg-gray-200', 'dark:bg-gray-700'); // Highlight drop zone
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('bg-gray-200', 'dark:bg-gray-700'); // Remove highlight
});

dropZone.addEventListener('drop', (event) => {
    event.preventDefault(); // Prevent default behavior
    dropZone.classList.remove('bg-gray-200', 'dark:bg-gray-700'); // Remove highlight

    const files = event.dataTransfer.files; // Get dropped files
    handleFiles(files);
});


// Handle drag events
dropZoneEdit.addEventListener('dragover', (event) => {
    event.preventDefault(); // Prevent default behavior
    dropZoneEdit.classList.add('bg-gray-200', 'dark:bg-gray-700'); // Highlight drop zone
});

dropZoneEdit.addEventListener('dragleave', () => {
    dropZoneEdit.classList.remove('bg-gray-200', 'dark:bg-gray-700'); // Remove highlight
});

dropZoneEdit.addEventListener('drop', (event) => {
    event.preventDefault(); // Prevent default behavior
    dropZoneEdit.classList.remove('bg-gray-200', 'dark:bg-gray-700'); // Remove highlight

    const files = event.dataTransfer.files; // Get dropped files
    handleFiles(files);
});

// Handle file input (click-based file selection)
fileInput.addEventListener('change', (event) => {
    handleFiles(event.target.files);
});

// Open file dialog on click
dropZone.addEventListener('click', () => {
    fileInput.click();
});

// Handle file input (click-based file selection)
fileInputEdit.addEventListener('change', (event) => {
    handleFilesEdit(event.target.files);
});

// Open file dialog on click
dropZoneEdit.addEventListener('click', () => {
    fileInputEdit.click();
});

// Handle file processing
function handleFiles(files) {
    fileList.innerHTML = ''; // Clear file list
    Array.from(files).forEach((file) => {
        if (file.size > 5 * 1024 * 1024) { // Validate file size (5MB)
            alert(`File ${file.name} exceeds the maximum size of 5MB.`);
            return;
        }
        const li = document.createElement('li');
        li.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
        fileList.appendChild(li);
    });
}

function handleFilesEdit(files) {
    fileListEdit.innerHTML = ''; // Clear file list
    Array.from(files).forEach((file) => {
        if (file.size > 5 * 1024 * 1024) { // Validate file size (5MB)
            alert(`File ${file.name} exceeds the maximum size of 5MB.`);
            return;
        }
        const li = document.createElement('li');
        li.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
        fileListEdit.appendChild(li);
    });
}

function getLocalStorage(){
    $('.tab-links button').removeClass('active');
    if(!$(".tab-content").hasClass("hidden")){
        $(".tab-content").addClass("hidden");
    }

    if(localStorage.getItem("project_tool") == 'documents'){
        $('.current-selected').html('Documents');
        $('.tab-content#documents').removeClass('hidden');
        $("[data-tab='documents']").addClass("active");
        
        
    }
    else if(localStorage.getItem("project_tool") == 'correspondence'){
        $('.current-selected').html('Correspondence');	
        $('.tab-content#correspondence').removeClass('hidden');
        $("[data-tab='correspondence']").addClass("active");

    }
    else if(localStorage.getItem("project_tool") == 'meeting_planing'){
        $('.current-selected').html('Meeting Minutes');
        $('.tab-content#meetings').removeClass('hidden');
        $("[data-tab='meetings']").addClass("active");

    }
    else if(localStorage.getItem("project_tool") == 'punch_list'){
        $('.current-selected').html('Punch List');
        $('.tab-content#punch-list').removeClass('hidden');
        $("[data-tab='punch-list']").addClass("active");
    }
    else if(localStorage.getItem("project_tool") == 'stakeholders'){
        $('.current-selected').html('Stakeholders');
        $("[data-tab='users']").addClass("active");

    }

}

function toggleModal(modalId, action) {
    const modal = document.getElementById(modalId);
    if (!modal) {
        console.error(`Modal with id "${modalId}" not found!`);
        return;
    }

    if (action === 'open') {
        modal.classList.remove('hidden');
    } else if (action === 'close') {
        modal.classList.add('hidden');
    } else {
        console.error(`Invalid action "${action}" for toggleModal. Use "open" or "close".`);
    }
}

window.toggleModal = toggleModal;

function convertToLowerCase() {
    var input = 'MARINA';
    alert(input.toLowerCase());
}
window.convertToLowerCase = convertToLowerCase;

// Use Choices.js for dropdowns
const populateChoices = (selector, options, multiple=false, placeholder=null) => {
    let element = document.getElementById(selector);
    options.forEach(option => {
        let opt = document.createElement('option');
        opt.value = option.value;
        opt.textContent = option.label;
        element.appendChild(opt);
    });
    new Choices(`#${selector}`, {
        searchEnabled: true,
        itemSelectText: '',
        removeItemButton: multiple, // Allow multiple for Assignees & Distribution, single for Received From
        placeholderValue: placeholder ? placeholder : `Select ${selector.replace('-', ' ')}`,
    });
};

let assignees_obj = {};
let distribution_obj = {};
let received_obj = {};
let reviewers_obj = {};

const populateChoices2 = (selector, options, multiple=false, placeholder=null) => {
    //alert('ok');
    let  obj = new Choices(`#${selector}`, {
        searchEnabled: true,
        //choices:options,
        itemSelectText: '',
        removeItemButton: multiple, // Allow multiple for Assignees & Distribution, single for Received From
        placeholderValue: placeholder ? placeholder : `Select ${selector.replace('-', ' ')}`,
    });	
  
        received_obj = obj;
        received_obj.setChoices(options);
        return received_obj;

};


window.populateChoices = populateChoices;
window.populateChoices2 = populateChoices2;
window.received_obj = received_obj;
window.getLocalStorage = getLocalStorage;



