class BookcaseItemView
	def render(view_params)
		view = %{
		<div class="manga_bookcase">
			<div class="inner_wrap">
				<div class="hover_filter"></div>
				<div class="floaty_frame"></div>
				<div class="floaty_wrap">
					<span>One Piece</span>
				</div><!--
		}
				for img_src in view_params['spines']
					view += %{
					--><div class="book_spine">
						<img src="#{img_src}" />
					</div><!--
					}
				end
				
		view += %{
			--></div>
		</div>
		}
	end
end
