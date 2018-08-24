@extends('templates.tpshop.master')
@section('main')
<div class="container_fullwidth">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h5 class="title contact-title">
					Contact Us
				</h5>
				<div class="clearfix">
				</div>
				<div class="map">
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d958.4549492668907!2d108.15611514446424!3d16.07483831525971!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1534511523758" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				<div class="clearfix">
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="contact-infoormation">
							<h5>
								Thông Tin Liên Hệ
							</h5>
							<p>
								Shop Thời Trang Nam Nữ TPShop gần cầu vượt Ngô Sỹ Liên. Mở Cửa 24/24h. 
							</p>
							<ul>
								<li>
									<span class="icon">
										<img src="{{$urlTpshop}}/images/message.png" alt="">
									</span>
									<p>
										ptnbk2401@gmail.com <br>
										ptnbk2401@outlook.com <br>
									</p>
								</li>
								<li>
									<span class="icon">
										<img src="{{$urlTpshop}}/images/phone.png" alt="">
									</span>
									<p>
										+84. 167.309.9406 <br>
										+84. 988.622.406 <br>
									</p>
								</li>
								<li>
									<span class="icon">
										<img src="{{$urlTpshop}}/images/address.png" alt="">
									</span>
									<p>
										No.86 Ngô Sỹ Liên, Hòa Khánh, Liên Chiểu, 
										<br>
										Đà Nẵng, Vietnam
									</p>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ContactForm">
							<h5>
								Contact Form
							</h5>
							<form method="post" action="{{ route('tpshop.contact.index') }}">
								@csrf
								<div class="row">
									<div class="col-md-6">
										<label>
											Your Name 
											<strong class="red">
												*
											</strong>
										</label>
										<input class="inputfild" type="text" name="fullname" value="{{ old('fullname') }}">
										<label class="red">{{$errors->first('fullname')}}</label>
									</div>
									<div class="col-md-6">
										<label>
											Your Email
											<strong class="red">
												*
											</strong>
										</label>
										<input class="inputfild" type="text" name="email" value="{{ old('email') }}">
										<label class="red">{{$errors->first('email')}}</label>

									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label>
											Your Message 
											<strong class="red">
												*
											</strong>
										</label>
										<textarea class="inputfild" rows="8" name="message">{{ old('message') }}</textarea>
										<label class="red">{{$errors->first('message')}}</label>
									</div>
								</div>
								<button class="pull-right" type="submit">
									Send Message
								</button>
							</form>
							<div>
								@if(Session::has('msg'))
									<div class="alert alert-success">{{Session::get('msg')}}</div>
								@endif
								@if(Session::has('msg-error'))
									<div class="alert alert-danger">{{Session::get('msg-error')}}</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix">
		</div>
	</div>
</div>


	
@endsection
