<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta name="robots" content="noindex" />
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>トークルーム｜ひまっち</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
		<meta name="description" content="" />
        <script type="text/javascript" src="https://himatch.jp/js/jquery-3.1.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="https://himatch.jp/css/common-pc-sub.css" />
        <link rel="stylesheet" type="text/css" href="https://himatch.jp/css/common-sp-sub.css" />
        <link rel="stylesheet" type="text/css" href="https://himatch.jp/css/common-sub.css" />
<script>
$(function(){
  $textarea = $('#message_textarea');
  $textarea_outer = $textarea.closest('.bottom_fixed');

  $textarea.on('input', function () {
    $textarea.height(0);
    $textarea.height(this.scrollHeight);
    $textarea_outer.height('auto');
  });
  const textarea_height = $textarea.height();
  const textarea_outer_height = $textarea_outer.height();

  $(".send-btn").on("click", function(){
    var talkroomid = $('.bottom_fixed').data('talkroom_id');
    var senderid = $('.bottom_fixed').data('sender_id');     
    var receiverid = $('.bottom_fixed').data('receiver_id');

    var message = document.getElementById('message_textarea').value;
    if (!message) {
      alert('コメントを入力してください。');
			return false;
    }

    $.ajax({
          url: 'https://himatch.jp/ajax/talkroom',
		  type: "post",
		  data: {
        talkroomid: talkroomid,
        senderid: senderid,
        receiverid: receiverid,
        message: message
			},
		})
    .done(function(data, textStatus, jqXHR){
      var data_json = JSON.parse(data);
      
      if (data_json.turn != 'first') {
        const element = document.querySelector('#talk_area');
        if (data_json.login_user_id == data_json.sender_id) {
          var createElement = '<div class="talk_area_inner"><div class="message_right"><div class="chatting"><div class="says_right"><p class="show_message">' + data_json.message + '</p></div><div class="talkroom_post_time">' + data_json.post_time + '</div></div></div></div>';
        }else{   
          var createElement = '<div class="talk_area_inner"><div class="message_left"><div class="faceicon"><img src="../images/icon/' + data_json.receiver_id + '/' + data_json.icon_name + '" class="user_icon_talkroom"></div><div class="chatting"><div class="says_left"><p class="show_message">' + data_json.message + '</p></div><div class="talkroom_post_time">' + data_json.post_time + '</div></div></div></div>';
        }
        element.insertAdjacentHTML('beforeend', createElement);
      }else{
        document.getElementById('initial_screen').innerHTML = '<div class="message_right"><div class="chatting"><div class="says_right"><p class="show_message">' + data_json.message + '</p></div><div>' + data_json.post_time + '</div></div></div>'; 
      }
      $textarea.val('');

      var scroll_potision = $(".scrollposition").offset().top;
      $('html, body').animate({scrollTop:scroll_potision}, 0, 'swing');
      $textarea.height(textarea_height);
      $textarea_outer.height(textarea_outer_height);
    })
    .fail(function(){
				alert("失敗しました。");
		});
  });
});

$(document).on("click", "#burgar_btn", function(){
  if($(this).hasClass('active')) {
    $(this).removeClass('active');
    $('#slide_menu').removeClass('open');
    $('.slide_menu_bg').removeClass('open');
  } else {
    $(this).addClass('active');
    $('#slide_menu').addClass('open');
    $('.slide_menu_bg').addClass('open');
    $('body').addClass('scroll_fixed');
  }
});

$(document).on("click", ".slide_menu_bg", function(){	
  if($(this).hasClass('open')) {
    $(this).removeClass('open');
    $('#burgar_btn').removeClass('active');
    $('#slide_menu').removeClass('open');
    $('body').removeClass('scroll_fixed');
  }
});
</script>
		<link rel="stylesheet" href="../css/common-sub.css" type="text/css" />
	</head>
<script src="https://js.stripe.com/v3/"></script>
<script type=text/javascript>
document.addEventListener('DOMContentLoaded', function() {
    // Stripe インスタンスを作成
    var stripe = Stripe('pk_test_51OxMuA2NouBXQI50Me70dbLZ9yjHd63umuaXEOxQUIlyl5vavfhDXA2otMSVtvRvUB7KRvm0QjeGAS8NCuUfHbpU00jEfWQedQ');  // 自分の公開可能なキーを使用
    var elements = stripe.elements();
    // カードエレメントの作成
    var card = elements.create('card', {
    style: {
        base: {
        color: '#32325d',  // テキストの色
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',  // フォント
        fontSmoothing: 'antialiased',  // フォントのスムージング
        fontSize: '16px',  // フォントサイズ
        '::placeholder': {
            color: '#aab7c4'  // プレースホルダーの色
        }
        },
        invalid: {
        color: '#fa755a',  // 無効なカード情報が入力された時のテキスト色
        iconColor: '#fa755a'  // 無効なアイコンの色
        }
    }
    });

    card.on('change', function(event) {
        if (event.error) {
            // エラーメッセージを表示
            document.getElementById('card-errors').textContent = event.error.message;
        }
    });

    // HTML にカードエレメントを埋め込む
    card.mount('#card-element');

    const stripe = Stripe(
            'pk_test_51OxMuA2NouBXQI50Me70dbLZ9yjHd63umuaXEOxQUIlyl5vavfhDXA2otMSVtvRvUB7KRvm0QjeGAS8NCuUfHbpU00jEfWQedQ'
        );
        const elements = stripe.elements();
        const style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                lineHeight: '24px',
                padding: '10px',
                '::placeholder': {
                    color: '#aab7c4'
                },
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const cardElement = elements.create('card', {
            style: style
        });
        cardElement.mount('#card-element');
});
</script>

<div id="card-element"></div>
<div id="card-errors" role="alert"></div>

<div id="card-element" class="StripeElement StripeElement--empty"><div class="__PrivateStripeElement" style="margin: 0px !important; padding: 0px !important; border: none !important; display: block !important; background: transparent !important; position: relative !important; opacity: 1 !important; --stripeElementWidth: 376px;"><iframe name="__privateStripeFrame1143" frameborder="0" allowtransparency="true" scrolling="no" role="presentation" allow="payment *" src="https://js.stripe.com/v3/elements-inner-card-0e97c3b6514a1bf6af0914bec5761221.html#wait=false&amp;mids[guid]=NA&amp;mids[muid]=b1457eff-0bc9-4309-8fc7-f08d2be1244983ad23&amp;mids[sid]=18e52c1d-305c-4e36-970d-6010dc242d92ffd8ff&amp;style[base][color]=%2332325d&amp;style[base][fontFamily]=%22Helvetica+Neue%22%2C+Helvetica%2C+sans-serif&amp;style[base][fontSmoothing]=antialiased&amp;style[base][fontSize]=16px&amp;style[base][lineHeight]=24px&amp;style[base][padding]=10px&amp;style[base][::placeholder][color]=%23aab7c4&amp;style[invalid][color]=%23fa755a&amp;style[invalid][iconColor]=%23fa755a&amp;rtl=false&amp;componentName=card&amp;keyMode=test&amp;apiKey=pk_test_51OxMuA2NouBXQI50Me70dbLZ9yjHd63umuaXEOxQUIlyl5vavfhDXA2otMSVtvRvUB7KRvm0QjeGAS8NCuUfHbpU00jEfWQedQ&amp;referrer=https%3A%2F%2Flocalhost%2FCW_52009489%2Fsample.html&amp;controllerId=__privateStripeController1141" title="セキュアなカード支払い入力フレーム" style="border: 0px !important; margin: 0px !important; padding: 0px !important; width: 1px !important; min-width: 100% !important; overflow: hidden !important; display: block !important; user-select: none !important; transform: translate(0px) !important; color-scheme: light only !important; height: 24px;"></iframe><input class="__PrivateStripeElement-input" aria-hidden="true" aria-label=" " autocomplete="false" maxlength="1" style="border: none !important; display: block !important; position: absolute !important; height: 1px !important; top: -1px !important; left: 0px !important; padding: 0px !important; margin: 0px !important; width: 100% !important; opacity: 0 !important; background: transparent !important; pointer-events: none !important; font-size: 16px !important;"><div style="display: block !important; position: absolute !important; top: 50% !important; right: -6px !important; width: 0px !important; margin: -16px 0px 0px !important; padding: 0px !important; border: 0px !important; background: none !important; opacity: 1 !important; overflow: hidden !important; pointer-events: auto !important; transition: width 0.4s !important; height: 32px !important;"><iframe name="cardButton1145" frameborder="0" allowtransparency="true" scrolling="no" src="https://js.stripe.com/v3/elements-inner-link-button-for-card-855eafb3794f4704152139291e5c9721.html#locale=ja&amp;style[foregroundColor]=%2332325d&amp;frameId=__privateStripeFrame1143&amp;publishableKey=pk_test_51OxMuA2NouBXQI50Me70dbLZ9yjHd63umuaXEOxQUIlyl5vavfhDXA2otMSVtvRvUB7KRvm0QjeGAS8NCuUfHbpU00jEfWQedQ&amp;stripeJsId=4349be4e-5a0c-4796-a5fa-affcd45a071e&amp;controllerId=__privateStripeController1141&amp;mids[guid]=f3c7e75a-3202-413e-999d-a19fc0308699799d33&amp;mids[muid]=b1457eff-0bc9-4309-8fc7-f08d2be1244983ad23&amp;mids[sid]=18e52c1d-305c-4e36-970d-6010dc242d92ffd8ff&amp;component=card" style="margin: 0px !important; user-select: none !important; transform: translate(0px) !important; color-scheme: light only !important; display: block !important; position: absolute !important; top: 0px !important; right: 0px !important; height: 32px !important; width: calc(var(--stripeElementWidth) + 12px) !important; padding: 0px !important; border: 0px !important; overflow: hidden !important; opacity: 1 !important; transition: visibility 0.4s !important; visibility: hidden !important;" tabindex="-1"></iframe></div></div></div>

<div id="card-element" class="StripeElement StripeElement--empty">
  <div class="__PrivateStripeElement" style="margin: 0px !important; padding: 0px !important; border: none !important; display: block !important; background: transparent !important; position: relative !important; opacity: 1 !important; --stripeElementWidth: 376px;">
    <iframe name="__privateStripeFrame1143" frameborder="0" allowtransparency="true" scrolling="no" role="presentation" allow="payment *" src="https://js.stripe.com/v3/elements-inner-card-0e97c3b6514a1bf6af0914bec5761221.html#wait=false&mids%5Bguid%5D=NA&mids%5Bmuid%5D=b1457eff-0bc9-4309-8fc7-f08d2be1244983ad23&mids%5Bsid%5D=18e52c1d-305c-4e36-970d-6010dc242d92ffd8ff&style%5Bbase%5D%5Bcolor%5D=%2332325d&style%5Bbase%5D%5BfontFamily%5D=%22Helvetica+Neue%22%2C+Helvetica%2C+sans-serif&style%5Bbase%5D%5BfontSmoothing%5D=antialiased&style%5Bbase%5D%5BfontSize%5D=16px&style%5Bbase%5D%5BlineHeight%5D=24px&style%5Bbase%5D%5Bpadding%5D=10px&style%5Bbase%5D%5B::placeholder%5D%5Bcolor%5D=%23aab7c4&style%5Binvalid%5D%5Bcolor%5D=%23fa755a&style%5Binvalid%5D%5BiconColor%5D=%23fa755a&rtl=false&componentName=card&keyMode=test&apiKey=pk_test_51OxMuA2NouBXQI50Me70dbLZ9yjHd63umuaXEOxQUIlyl5vavfhDXA2otMSVtvRvUB7KRvm0QjeGAS8NCuUfHbpU00jEfWQedQ&referrer=https%3A%2F%2Flocalhost%2FCW_52009489%2Fsample.html&controllerId=__privateStripeController1141" title="セキュアなカード支払い入力フレーム" style="border: 0px !important; margin: 0px !important; padding: 0px !important; width: 1px !important; min-width: 100% !important; overflow: hidden !important; display: block !important; user-select: none !important; transform: translate(0px) !important; color-scheme: light only !important; height: 24px;">
    </iframe>
    <input class="__PrivateStripeElement-input" aria-hidden="true" aria-label=" " autocomplete="false" maxlength="1" style="border: none !important; display: block !important; position: absolute !important; height: 1px !important; top: -1px !important; left: 0px !important; padding: 0px !important; margin: 0px !important; width: 100% !important; opacity: 0 !important; background: transparent !important; pointer-events: none !important; font-size: 16px !important;">
    <div style="display: block !important; position: absolute !important; top: 50% !important; right: -6px !important; width: 0px !important; margin: -16px 0px 0px !important; padding: 0px !important; border: 0px !important; background: none !important; opacity: 1 !important; overflow: hidden !important; pointer-events: auto !important; transition: width 0.4s !important; height: 32px !important;">
      <iframe name="cardButton1145" frameborder="0" allowtransparency="true" scrolling="no" src="https://js.stripe.com/v3/elements-inner-link-button-for-card-855eafb3794f4704152139291e5c9721.html#locale=ja&style%5BforegroundColor%5D=%2332325d&frameId=__privateStripeFrame1143&publishableKey=pk_test_51OxMuA2NouBXQI50Me70dbLZ9yjHd63umuaXEOxQUIlyl5vavfhDXA2otMSVtvRvUB7KRvm0QjeGAS8NCuUfHbpU00jEfWQedQ&stripeJsId=4349be4e-5a0c-4796-a5fa-affcd45a071e&controllerId=__privateStripeController1141&mids%5Bguid%5D=f3c7e75a-3202-413e-999d-a19fc0308699799d33&mids%5Bmuid%5D=b1457eff-0bc9-4309-8fc7-f08d2be1244983ad23&mids%5Bsid%5D=18e52c1d-305c-4e36-970d-6010dc242d92ffd8ff&component=card" style="margin: 0px !important; user-select: none !important; transform: translate(0px) !important; color-scheme: light only !important; display: block !important; position: absolute !important; top: 0px !important; right: 0px !important; height: 32px !important; width: calc(var(--stripeElementWidth) + 12px) !important; padding: 0px !important; border: 0px !important; overflow: hidden !important; opacity: 1 !important; transition: visibility 0.4s !important; visibility: hidden !important;" tabindex="-1">
      </iframe>
    </div>
  </div>
</div>

<div tabindex="-1" class="CardField is-link-hidden previous-link-hidden CardField--ltr">
  <div class="CardBrandIcon-container" aria-hidden="true" data-front-icon-name="unknown" data-back-icon-name="cvc">
    <div class="CardBrandIcon-wrapper">
      <div class="Icon CardBrandIcon is-cvc-hidden is-loaded">
        <div class="CardBrandIcon-inner CardBrandIcon-inner--front">
          <svg focusable="false" viewbox="0 0 29 19">
            <g fill="none" fill-rule="evenodd">
              <g class="Icon-fill">
                <path opacity="0.2" d="M26.58 19.0001H2.42C2.10482 19.0027 1.79222 18.9433 1.50002 18.8251C1.20783 18.7069 0.941782 18.5323 0.717062 18.3113C0.492342 18.0903 0.313355 17.8272 0.190321 17.537C0.0672866 17.2468 0.00261552 16.9353 0 16.6201L0 2.38008C0.00261552 2.06491 0.0672866 1.75333 0.190321 1.46315C0.313355 1.17297 0.492342 0.909867 0.717062 0.688861C0.941782 0.467855 1.20783 0.293278 1.50002 0.175097C1.79222 0.0569162 2.10482 -0.00255337 2.42 8.40317e-05H26.58C26.8952 -0.00255337 27.2078 0.0569162 27.5 0.175097C27.7922 0.293278 28.0582 0.467855 28.2829 0.688861C28.5077 0.909867 28.6866 1.17297 28.8097 1.46315C28.9327 1.75333 28.9974 2.06491 29 2.38008V16.6301C28.9921 17.2649 28.733 17.8707 28.2794 18.3148C27.8259 18.759 27.2148 19.0054 26.58 19.0001ZM10 5.83008C10 5.37008 9.65 5.00008 9.22 5.00008H3.78C3.35 5.00008 3 5.37008 3 5.83008V9.17008C3 9.63008 3.35 10.0001 3.78 10.0001H9.22C9.65 10.0001 10 9.63008 10 9.17008V5.83008Z">
                </path>
                <path opacity="0.3" d="M25 15H22C21.35 15 21 14.7 21 14C21 13.3 21.35 13 22 13H25C25.65 13 26 13.3 26 14C26 14.7 25.65 15 25 15ZM19 15H16C15.35 15 15 14.7 15 14C15 13.3 15.35 13 16 13H19C19.65 13 20 13.3 20 14C20 14.7 19.65 15 19 15ZM13 15H10C9.35 15 9 14.7 9 14C9 13.3 9.35 13 10 13H13C13.65 13 14 13.3 14 14C14 14.7 13.65 15 13 15ZM7 15H4C3.35 15 3 14.7 3 14C3 13.3 3.35 13 4 13H7C7.65 13 8 13.3 8 14C8 14.7 7.65 15 7 15Z">
                </path>
              </g>
            </g>
          </svg>
        </div>
        <div class="CardBrandIcon-inner CardBrandIcon-inner--back">
          <svg class="" focusable="false" viewbox="0 0 32 21" role="img" aria-label="CVC">
            <title>CVC</title>
            <g fill="none" fill-rule="evenodd">
              <g class="Icon-fill">
                <g transform="translate(0 2)">
                  <path d="M21.68 0H2c-.92 0-2 1.06-2 2v15c0 .94 1.08 2 2 2h25c.92 0 2-1.06 2-2V9.47a5.98 5.98 0 0 1-3 1.45V11c0 .66-.36 1-1 1H3c-.64 0-1-.34-1-1v-1c0-.66.36-1 1-1h17.53a5.98 5.98 0 0 1 1.15-9z" opacity=".2">
                  </path>
                  <path d="M19.34 3H0v3h19.08a6.04 6.04 0 0 1 .26-3z" opacity=".3">
                  </path>
                </g>
                <g transform="translate(18)">
                  <path d="M7 14A7 7 0 1 1 7 0a7 7 0 0 1 0 14zM4.22 4.1h-.79l-1.93.98v1l1.53-.8V9.9h1.2V4.1zm2.3.8c.57 0 .97.32.97.78 0 .5-.47.85-1.15.85h-.3v.85h.36c.72 0 1.21.36 1.21.88 0 .5-.48.84-1.16.84-.5 0-1-.16-1.52-.47v1c.56.24 1.12.37 1.67.37 1.31 0 2.21-.67 2.21-1.64 0-.68-.42-1.23-1.12-1.45.6-.2.99-.73.99-1.33C8.68 4.64 7.85 4 6.65 4a4 4 0 0 0-1.57.34v.98c.48-.27.97-.42 1.44-.42zm4.32 2.18c.73 0 1.24.43 1.24.99 0 .59-.51 1-1.24 1-.44 0-.9-.14-1.37-.43v1.03c.49.22.99.33 1.48.33.26 0 .5-.04.73-.1.52-.85.82-1.83.82-2.88l-.02-.42a2.3 2.3 0 0 0-1.23-.32c-.18 0-.37.01-.57.04v-1.3h1.44a5.62 5.62 0 0 0-.46-.92H9.64v3.15c.4-.1.8-.17 1.2-.17z">
                  </path>
                </g>
              </g>
            </g>
          </svg>
        </div>
      </div>
      <div class="CardBrandChoiceDropdown-container">
        <svg class="CardBrandChoiceDropdown-icon Icon" focusable="false" viewbox="0 0 16 16">
          <path fill-rule="evenodd" fill-opacity="0.4" class="TextColorIcon-fill" d="M13.591 5.293a1 1 0 1 1 1.416 1.416l-6.3 6.3a1 1 0 0 1-1.414 0l-6.3-6.3A1 1 0 0 1 2.41 5.293L8 10.884l5.591-5.59Z">
          </path>
        </svg>
        <select class="CardBrandChoiceDropdown" autocomplete="off" disabled aria-label="カードブランドを選択 (任意)">
          <option value="" disabled>カードブランドを選択 (任意)</option>
        </select>
      </div>
    </div>
  </div>
  <div class="CardField-input-wrapper" dir="ltr">
    <span class="CardField-number CardField-child" style="transform: translateX(0px);">
      <span class="CardField-number-fakeNumber" aria-hidden="true">
        <span class="CardField-number-fakeNumber-last4 InputElement">
        </span>
        <span class="CardField-number-fakeNumber-number">番号</span>
      </span>
      <span>
        <div tabindex="-1" class="CardNumberField CardNumberField--ltr" aria-hidden="false">
          <div class="CardBrandIcon-container is-hidden" aria-hidden="true" data-front-icon-name="unknown" data-back-icon-name="cvc">
            <div class="CardBrandIcon-wrapper">
              <div class="Icon CardBrandIcon is-cvc-hidden is-loaded">
                <div class="CardBrandIcon-inner CardBrandIcon-inner--front">
                  <svg focusable="false" viewbox="0 0 29 19">
                    <g fill="none" fill-rule="evenodd">
                      <g class="Icon-fill">
                        <path opacity="0.2" d="M26.58 19.0001H2.42C2.10482 19.0027 1.79222 18.9433 1.50002 18.8251C1.20783 18.7069 0.941782 18.5323 0.717062 18.3113C0.492342 18.0903 0.313355 17.8272 0.190321 17.537C0.0672866 17.2468 0.00261552 16.9353 0 16.6201L0 2.38008C0.00261552 2.06491 0.0672866 1.75333 0.190321 1.46315C0.313355 1.17297 0.492342 0.909867 0.717062 0.688861C0.941782 0.467855 1.20783 0.293278 1.50002 0.175097C1.79222 0.0569162 2.10482 -0.00255337 2.42 8.40317e-05H26.58C26.8952 -0.00255337 27.2078 0.0569162 27.5 0.175097C27.7922 0.293278 28.0582 0.467855 28.2829 0.688861C28.5077 0.909867 28.6866 1.17297 28.8097 1.46315C28.9327 1.75333 28.9974 2.06491 29 2.38008V16.6301C28.9921 17.2649 28.733 17.8707 28.2794 18.3148C27.8259 18.759 27.2148 19.0054 26.58 19.0001ZM10 5.83008C10 5.37008 9.65 5.00008 9.22 5.00008H3.78C3.35 5.00008 3 5.37008 3 5.83008V9.17008C3 9.63008 3.35 10.0001 3.78 10.0001H9.22C9.65 10.0001 10 9.63008 10 9.17008V5.83008Z">
                        </path>
                        <path opacity="0.3" d="M25 15H22C21.35 15 21 14.7 21 14C21 13.3 21.35 13 22 13H25C25.65 13 26 13.3 26 14C26 14.7 25.65 15 25 15ZM19 15H16C15.35 15 15 14.7 15 14C15 13.3 15.35 13 16 13H19C19.65 13 20 13.3 20 14C20 14.7 19.65 15 19 15ZM13 15H10C9.35 15 9 14.7 9 14C9 13.3 9.35 13 10 13H13C13.65 13 14 13.3 14 14C14 14.7 13.65 15 13 15ZM7 15H4C3.35 15 3 14.7 3 14C3 13.3 3.35 13 4 13H7C7.65 13 8 13.3 8 14C8 14.7 7.65 15 7 15Z">
                        </path>
                      </g>
                    </g>
                  </svg>
                </div>
                <div class="CardBrandIcon-inner CardBrandIcon-inner--back">
                  <svg class="" focusable="false" viewbox="0 0 32 21" role="img" aria-label="CVC">
                    <title>CVC</title>
                    <g fill="none" fill-rule="evenodd">
                      <g class="Icon-fill">
                        <g transform="translate(0 2)">
                          <path d="M21.68 0H2c-.92 0-2 1.06-2 2v15c0 .94 1.08 2 2 2h25c.92 0 2-1.06 2-2V9.47a5.98 5.98 0 0 1-3 1.45V11c0 .66-.36 1-1 1H3c-.64 0-1-.34-1-1v-1c0-.66.36-1 1-1h17.53a5.98 5.98 0 0 1 1.15-9z" opacity=".2">
                          </path>
                          <path d="M19.34 3H0v3h19.08a6.04 6.04 0 0 1 .26-3z" opacity=".3">
                          </path>
                        </g>
                        <g transform="translate(18)">
                          <path d="M7 14A7 7 0 1 1 7 0a7 7 0 0 1 0 14zM4.22 4.1h-.79l-1.93.98v1l1.53-.8V9.9h1.2V4.1zm2.3.8c.57 0 .97.32.97.78 0 .5-.47.85-1.15.85h-.3v.85h.36c.72 0 1.21.36 1.21.88 0 .5-.48.84-1.16.84-.5 0-1-.16-1.52-.47v1c.56.24 1.12.37 1.67.37 1.31 0 2.21-.67 2.21-1.64 0-.68-.42-1.23-1.12-1.45.6-.2.99-.73.99-1.33C8.68 4.64 7.85 4 6.65 4a4 4 0 0 0-1.57.34v.98c.48-.27.97-.42 1.44-.42zm4.32 2.18c.73 0 1.24.43 1.24.99 0 .59-.51 1-1.24 1-.44 0-.9-.14-1.37-.43v1.03c.49.22.99.33 1.48.33.26 0 .5-.04.73-.1.52-.85.82-1.83.82-2.88l-.02-.42a2.3 2.3 0 0 0-1.23-.32c-.18 0-.37.01-.57.04v-1.3h1.44a5.62 5.62 0 0 0-.46-.92H9.64v3.15c.4-.1.8-.17 1.2-.17z">
                          </path>
                        </g>
                      </g>
                    </g>
                  </svg>
                </div>
              </div>
              <div class="CardBrandChoiceDropdown-container">
                <svg class="CardBrandChoiceDropdown-icon Icon" focusable="false" viewbox="0 0 16 16">
                  <path fill-rule="evenodd" fill-opacity="0.4" class="TextColorIcon-fill" d="M13.591 5.293a1 1 0 1 1 1.416 1.416l-6.3 6.3a1 1 0 0 1-1.414 0l-6.3-6.3A1 1 0 0 1 2.41 5.293L8 10.884l5.591-5.59Z">
                  </path>
                </svg>
                <select class="CardBrandChoiceDropdown" autocomplete="off" disabled aria-label="カードブランドを選択 (任意)">
                  <option value="" disabled>カードブランドを選択 (任意)</option>
                </select>
              </div>
            </div>
          </div>
          <div class="CardNumberField-input-wrapper">
            <span class="InputContainer" data-max="4242 4242 4242 4242 4240">
              <input class="InputElement is-empty Input Input--empty" autocomplete="cc-number" autocorrect="off" spellcheck="false" type="text" name="cardnumber" data-elements-stable-field-name="cardNumber" inputmode="numeric" aria-label="クレジットカードまたはデビットカード番号" placeholder="カード番号" aria-invalid="false" tabindex="0" value="">
            </span>
          </div>
        </div>
      </span>
    </span>
    <span class="CardField-restWrapper CardField-restWrapper--cvcHiddenWhileEmpty">
      <span class="CardField-expiry CardField-child" style="transform: translateX(90px);">
        <span>
          <span class="InputContainer" data-max="00 / 000">
            <input class="InputElement is-empty Input Input--empty" autocomplete="cc-exp" autocorrect="off" spellcheck="false" type="text" name="exp-date" data-elements-stable-field-name="cardExpiry" inputmode="numeric" aria-label="クレジットカードまたはデビットカードの有効期限" placeholder="月 / 年" aria-invalid="false" tabindex="0" value="">
          </span>
        </span>
      </span>
      <span class="CardField-cvc CardField-child" style="transform: translateX(90px);">
        <span>
          <span class="InputContainer" data-max="セキュリティコード0">
            <input class="InputElement is-empty Input Input--empty" autocomplete="cc-csc" autocorrect="off" spellcheck="false" type="text" name="cvc" data-elements-stable-field-name="cardCvc" inputmode="numeric" aria-label="クレジットカードまたはデビットカードのCVC/CVV" placeholder="セキュリティコード" aria-invalid="false" tabindex="0" value="">
          </span>
        </span>
      </span>
      <span class="CardField-postalCode CardField-child" style="transform: translateX(90px);">
        <span>
        </span>
      </span>
    </span>
  </div>
</div>