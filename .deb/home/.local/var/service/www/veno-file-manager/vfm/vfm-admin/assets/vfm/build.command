cd /Applications/MAMP/htdocs/veno-file-manager-bs5/veno-file-manager/vfm

uglifyjs vfm-admin/assets/soundmanager/soundmanager2-nodebug-jsmin.js vfm-admin/assets/vfm/js/vfm-inlineplayer.js vfm-admin/assets/initial/initial.min.js vfm-admin/assets/cropit/jquery.cropit.min.js vfm-admin/assets/vfm/js/avatars.js vfm-admin/assets/bootbox/bootbox.min.js vfm-admin/assets/datatables/datatables.min.js vfm-admin/assets/clipboard/clipboard.min.js vfm-admin/assets/uploaders/resumable.js vfm-admin/assets/uploaders/jquery.form.min.js vfm-admin/assets/vfm/js/uploaders.js vfm-admin/assets/vfm/js/app.js -o vfm-admin/js/vfm-bundle.min.js

uglifyjs vfm-admin/assets/vfm/js/registration.js -o vfm-admin/js/registration.min.js

cleancss -o vfm-admin/css/vfm-bundle.min.css vfm-admin/assets/datatables/datatables.min.css vfm-admin/assets/videojs/video-js.min.css vfm-admin/assets/vfm/css/vfm-style.css