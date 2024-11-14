import $ from 'jquery';
import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import feather from 'feather-icons';

window.$ = $;
window.feather = feather;

$(document).ready(function() {
    feather.replace({ 'stroke-width': 1 });
    $('.tab-links button').click(function() {
        // Remove .active class from all buttons
        let tablinks = $(this).closest('.tab-links');
        tablinks.find('button').removeClass('active');
        
        // Add .active class to the clicked button
        $(this).addClass('active');

        // Hide all tab contents
        $(`.tab-view[data-tabs=${tablinks.data('tabs')}] .tab-content`).addClass('hidden');

        // Show the target tab content
        let target = $(this).data('tab');
        console.log(target);
        $(`.tab-content#${target}`).removeClass('hidden');
    });
});

