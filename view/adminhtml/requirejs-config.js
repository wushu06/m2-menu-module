
var config = {
    deps: ['Tbb_Menu/js/sortable'],
    paths: {

        'tbb/jstree': 'Tbb_Menu/js/jstree.min',
        'tbb/nest'  : 'Tbb_Menu/js/jquery.nestable'
    },
	shim: {
		'tbb/jstree': {
			deps: ['jquery']
		},
		'tbb/nest': {
			deps: ['jquery']
		},
	}
};