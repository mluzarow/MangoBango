class LibraryPage
	def initialize()
		@view_params = {
			'spines' => [
				'resources/img/test_spine_01.jpg',
				'resources/img/test_spine_02.jpg',
				'resources/img/test_spine_03.jpg',
				'resources/img/test_spine_04.jpg',
				'resources/img/test_spine_05.jpg',
				'resources/img/test_spine_06.jpg',
				'resources/img/test_spine_07.jpg'
			]
		}
	end
	
	def render()
		LibraryPageView.new(@view_params).render()
	end
end
