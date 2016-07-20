@extends('template.main')

@section('content')

<!-- Header -->

<div class="section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="main-header">Welcome!</h1>
				<h4>Have a look around.</h4>
			</div>
		</div>
	</div>
</div>

<!--End Header-->

	<!--Lists-->
	<div class="section section-with-space">
		<div class="container">
			<div class="row"">
				<div class="col-md-12">
					<h3>Popular Summoners</h3>
					<div class="dropdown">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					All Regions
					<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li><a href="#">North America</a></li>
					<li><a href="#">Latin America North</a></li>
					<li><a href="#">Latin America South</a></li>
					<li><a href="#">Brazil</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">Europe West</a></li>
					<li><a href="#">Europe Nordic &amp; East</a></li>
					<li><a href="#">Russia</a></li>
					<li><a href="#">Turkey</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">South Korea</a></li>
					<li><a href="#">Oceania</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="#">All Regions</a></li>
					</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="list-plate-wrapper">
					@foreach($summoners as $summoner)
						<div class=" col-md-8 list-plate-outer">
							<a href="{{ url('/') }}/{{ $summoner->region }}/{{ $summoner->playerName }}">
								<img class="avatar" src="http://ddragon.leagueoflegends.com/cdn/6.12.1/img/profileicon/{{ $summoner->profileIconId }}.png" class="media-photo">
							</a>
							<div class="list-plate-inner">
								<div class="list-plate-region">{{ $summoner->region }}</div>
								<div class="list-plate-name"><a href="{{ url('/') }}/{{ $summoner->region }}/{{ $summoner->playerName }}">{{ $summoner->playerName }}</a></div>
								<div class="list-plate-division">	{{ $summoner->tier }} {{ $summoner->division }}</div>
								<div class="list-plate-button-outer">
									<span class="list-plate-button">
										@if(!Auth::guest())
											@if(!$summoner->liked)
												<a href="#" id="{{ $summoner->playerId }}_{{ $summoner->region }}" class=" glyphicon glyphicon-heart heart-liked ajax-like">
												</a>
											@else
												<a href="#" id="{{ $summoner->playerId }}_{{ $summoner->region }}" class=" glyphicon glyphicon-heart heart-unliked ajax-like">
												</a>
											@endif
										@else
											<a href="{{ route('users.login') }}" class=" glyphicon glyphicon-heart heart-unliked">
											</a>
										@endif
										{{ $summoner->likes }}
									</span>
									<span class="list-plate-button">
										<span class="glyphicon glyphicon-comment"></span>
										{{ $summoner->comments }}
									</span>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
		<div class="text-center">
			{!! $summoners->render() !!}
		</div>
	</div>
	<div class="section section-light-brown section-with-space">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3>Newest Comments</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					Jerry > Populum <span class="timestamp">&bull; 1d</span>
					<p>This is a comment.</p>
					<a class="btn btn-danger btn-simple" href="#">Go to Populum's Page</a>
				</div>
				<div class="col-md-6">2
					Jerry > Populum <span class="timestamp">&bull; 1d</span>
					<p>This is a comment.</p>
					<a class="btn btn-danger btn-simple" href="#">Go to Populum's Page</a>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">

		$(document).ready(function($) {
			$(".table-row").click(function() {
				window.document.location = $(this).data("href");
			});
		});

		$(function() {
                $('.ajax-like').click(function(e) {
                    e.preventDefault();
                    var id=$(this).attr("id");
                    $.post('{{ route('summoners.like') }}', {
                        "summonerId_region" : $(this).attr("id")
                    }, function(response) {
                        if(response.result != null && response.result == '1'){
                            if(response.isunlike=='1'){
                                $("#"+id).removeClass('text-danger');
                                $("#"+id).addClass('text-primary');
                            }else{
                                $("#"+id).removeClass('text-primary');
                                $("#"+id).addClass('text-danger');
                            }
                        }else{
                            alert("Server Error");
                        }
                    }, "json").always(function() {
                        //l.stop();
                    });
                    return false;
                });
            });

		var region = "na";

		$(function(){

			$(".dropdown-menu li a").click(function(){
			  $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
			  $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
			  region = $(this).text().toLowerCase();

			});

		});

		document.getElementById('frmSearch').onsubmit = function() {
	        window.location = '{{ url('/') }}/' + region + '/' + document.getElementById('txtSearch').value;
	        return false;
	    }

	</script>

	<!--End Lists-->
@endsection
