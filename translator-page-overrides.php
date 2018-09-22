<?php
if (!defined('QA_VERSION')) {
    header('Location: ../../');
    exit;
}
function qa_admin_sub_navigation() {
    $navigation = qa_admin_sub_navigation_base();
    if(qa_get_logged_in_level() >= QA_USER_LEVEL_ADMIN) {
        $navigation['translator'] = array(
            'label' => 'Translator',
            'url' => qa_path('admin/translator'),
            'selected' => (qa_request_part(1) == 'translator')? true : null,
        );
    }
    return $navigation;
}
