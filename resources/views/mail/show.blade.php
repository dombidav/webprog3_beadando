@php
    use App\Mail;
    /** @var Mail $mail */
@endphp

<div class="row border">
    <div class="col-4">
        <a href="{{ route('user.show', $mail->sender()->first()) }}"
           class="btn btn-block btn-outline-primary text-nowrap">From: {{ $mail->sender()->first()->full_name }} </a>
    </div>
    <div class="col-4 align-content-center align-items-center">
        <p class="small text-center">{{ $mail->created_at }}</p>
    </div>
    <div class="col-4">
        <a href="{{ route('user.show', $mail->recipient()->first()) }}"
           class="btn btn-block btn-outline-primary text-nowrap">To: {{ $mail->recipient()->first()->full_name }} </a>
    </div>
</div>
<div class="row border">
    <p class="lead">Subject: {{ $mail->subject }}</p>
</div>
<div class="row border">
    <div class="d-block">
        @php
            $Parsedown = new Parsedown();
            $Parsedown->setBreaksEnabled(true)->setSafeMode(true)->setMarkupEscaped(true);
            echo $Parsedown->text($mail->content);
        @endphp
    </div>
</div>

<input type="hidden" id="mail_count_ajax" value="{{ Auth::user()->inbox_count() }}">
