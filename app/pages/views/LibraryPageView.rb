require_relative 'BookcaseItemView'

class LibraryPageView
	def initialize(view_params)
		@view_params = view_params
	end
	
	def render()
		%{
			<html>
			<head>
				<meta charset="UTF-8">
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
				<title>Library</title>
			</head>
			<body>
				<div class="lib_inner_wrap">
					#{BookcaseItemView.new.render(@view_params)}
				</div>
				#{css_render}
				#{js_render}
			</body>
			</html>
		}
	end
	
	private
	def js_render()
		%{
		<script>
			$(".manga_bookcase").click (function () {
				if ($(this).hasClass ("selected")) {
					$(this).removeClass ("selected");
				} else {
					$(this).addClass ("selected");
				}
			});
		</script>	
		}
	end
	
	def css_render()
		%{
		<style>
			html, body {
				margin: 0;
				padding: 0;
				font-family: "Arial";
			}
			
			body {
				background-color: #2e1208;
			}
			
			.header_bar {
				position: relative;
				top: 0;
				width: 100%;
				height: 3em;
				background-color: #000;
			}
			
			.header_bar .logo {
				width: 200px;
				height: 100%;
				display: inline-block;
			}
			
			.header_bar .logo::before {
				width: 0;
				height: 100%;
				display: inline-block;
				content: '';
				vertical-align: middle;
			}
			
			.header_bar .logo span {
				display: inline-block;
				color: #dd4e1d;
				text-align: center;
				font-size: 2em;
				vertical-align: middle;
			}
			
			.header_bar .breadcumbs {
				display: inline-block;
				color: white;
				font-size: 1.1em;
			}
			
			.header_bar .options {
				position: absolute;
				right: 0;
				height: 100%;
				display: inline-block;
				cursor: pointer;
			}
			
			.header_bar .options::before {
				width: 0;
				height: 100%;
				display: inline-block;
				content: '';
				vertical-align: middle;
			}
			
			.header_bar .options img {
				width: 40px;
				vertical-align: middle;
			}
			
			/* Manga display container */
			.lib_container {
				display: block;
			}
			
			.lib_inner_wrap {
				padding: 25px;
			}
			
			.bookcase_mount {
				margin: 2px 0 0 -25px;
				width: calc(100% + 50px);
				height: 8px;
				background-color: #151515;
			}
			
			/* Manga block display */
			.manga_block {
				display: inline-block;
				cursor: pointer;
			}
			
			.manga_block .img_wrap {
				width: 200px;
			}
			
			.manga_block .img_wrap img {
				max-width: 100%;
				vertical-align: top;
			}
			
			.manga_block .summary_wrap {
				display: block;
				color: #db5501;
			}
			
			.manga_block .summary_wrap .title {
				font-size: 1.5em;
			}
			
			.manga_block .summary_wrap .title span,
			.manga_block .summary_wrap .volumes span {
				display: block;
				text-align: center;
			}
			
			/* Manga bookcase display */
			.manga_bookcase {
				display: inline-block;
			}
			
			.manga_bookcase .inner_wrap {
				position: relative;
				cursor: pointer;
			}
			
			.manga_bookcase.selected .inner_wrap {
				cursor: default;
			}
			
			.manga_bookcase .inner_wrap:hover .hover_filter,
			.manga_bookcase .inner_wrap:hover .floaty_frame,
			.manga_bookcase .inner_wrap:hover .floaty_wrap {
				display: block;
			}
			
			.manga_bookcase.selected .inner_wrap:hover .hover_filter {
				display: none;
			}
			
			.manga_bookcase .hover_filter {
				position: absolute;
				width: 100%;
				height: 100%;
				display: none;
				background-color: #76767680;
			}
			
			.manga_bookcase .floaty_frame {
				position: absolute;
				top: 100%;
				margin-top: 10px;
				width: 100%;
				height: 10px;
				display: none;
				border-right: 1px solid white;
				border-bottom: 1px solid white;
				border-left: 1px solid white;
			}
			
			.manga_bookcase.selected .floaty_frame {
				display: block;
			}
			
			.manga_bookcase .floaty_frame::before {
				position: absolute;
				top: 100%;
				left: calc(50% - 8px);
				width: 0;
				height: 0;
				border-top: 12px solid aliceblue;
				border-right: 8px solid transparent;
				border-left: 8px solid transparent;
				content: '';
			}
			
			.manga_bookcase .floaty_wrap {
				position: absolute;
				top: 100%;
				margin-top: 34px;
				padding: 10px;
				width: 100%;
				display: none;
				border: 1px solid white;
				border-radius: 4px;
				box-sizing: border-box;
				color: white;
			}
			
			.manga_bookcase.selected .floaty_wrap {
				display: block;
			}
			
			.manga_bookcase .floaty_wrap span {
				display: block;
				text-align: center;
			}
			
			.manga_bookcase .book_spine {
				padding: 0 1px;
				width: 20px;
				height: 250px;
				display: inline-block;
			}
			
			.manga_bookcase .book_spine img {
				max-width: 100%;
				height: 100%;
				vertical-align: top;
			}
		</style>
		}
	end
end
