// Show active page
if (window.location.pathname !== '/') {
    var parent = $('a[href="' + window.location.pathname + '"]').parent();
    if (parent.length >= 1) {
      if (parent[0].localName === 'li') {  // Current page is under a dropdown
        parent.addClass('active');
      }
      else {
        parent.parent().addClass('active');
      }
    }
}
