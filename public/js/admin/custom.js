// when the element with the id of 'copy_to_clip' is clicked, copy the text from the element with the name of 'external_link' to the clipboard
jQuery('#copy_to_clip').click(function () {
    var copyText = jQuery('input[name="external_link"]').val();
    copyStringToClipboard(copyText);
    alert('Copied Proposal Link to Clipboard');
});

function copyStringToClipboard(str) {
    var el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style = {position: 'absolute', left: '-9999px'};
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
}

// allows for clipboard copying of the e-sig on the list view
$(document).on('click', '.copy_to_clip_list', function () {
    var copyText = jQuery(this).attr('data-clipboard-text');
    copyStringToClipboardList(copyText);
    alert('Copied Proposal Link to Clipboard');
});

function copyStringToClipboardList(str) {
    var el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style = {position: 'absolute', left: '-9999px'};
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
}

// changes the wording on the tc download button on the edit screen
var target = jQuery('.existing-file a').first();
var href = target.attr('href');
var newHref = href.replace('https://proposal.staging-sites.com.au/', 'https://proposal.staging-sites.com.au/storage/');
var newTarget = jQuery('<a href="' + newHref + '" target="_blank">Preview File</a>');
target.empty().html(newTarget);


