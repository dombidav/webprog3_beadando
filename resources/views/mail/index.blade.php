@php
    use App\Mail;
    use Illuminate\Database\Eloquent\Collection;
    /** @var Collection $mails */
    /** @var Mail $mail */
@endphp

@foreach($mails as $mail)
    <div class="row border">
        <a onclick="selectMail({{ $mail->id }})" class="btn btn-block {{ $mail->id == $selected ? 'btn-primary' : ($mail->is_new ? 'btn-outline-warning' : 'btn-light') }}">
            <div class="col">
                <div class="row">
                    <div class="col-7">
                        <h5 class="text-left text-nowrap text-truncate {{ $mail->id == $selected ? 'text-white' : '' }}">{!! $mail->is_new ? '<i class="text-warning fas fa-exclamation-circle"></i> ' : '' !!}{{ $mail->sender->full_name }}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="lead text-justify">{{ $mail->subject }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col align-self-center">
                        <p class="text-nowrap align-items-center text-right align-content-center">{{ $mail->created_at }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach
