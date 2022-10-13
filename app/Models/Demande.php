<?php

namespace App\Models;

use App\Enum\DemandeStatus;
use App\Enum\RejectRaison;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use OwenIt\Auditing\Contracts\Auditable;

class Demande extends Model implements Auditable
{
    use HasFactory, Notifiable, \OwenIt\Auditing\Auditable;


    protected $guarded = [];

    protected $casts = [
        'status' => DemandeStatus::class,
        'reject_reason' => RejectRaison::class,
    ];

    // bordereau link attribute
    public function getBordereauLinkAttribute()
    {
        $url = config('services.e-releve.url');
        return "{$url}/demandes/{$this->id}/bordereaux";
    }


    /**
     * @throws JsonException
     */
    public function setGradesAttribute($grades)
    {
        $this->attributes['grades'] = Json::encode($grades);
    }


    /**
     * @throws JsonException
     */
    public function getGradesAttribute($grades)
    {
        // grades is a json string so we need to decode
        return Json::decode($grades);

    }

    // get filiere attribute, upper case and remove space between words
    public function getFiliereAttribute()
    {
        return $this->filiere_code;
    }

    // bordereaux relation form media model, using polymorphic relation
    public function bordereaux(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    // status

    // user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getReleveLocationAttribute()
    {
        return $this->generateReleveLink();
    }

    // get releve lcation with grade attribute

    public function generateReleveLink(string $grade = "BAC3"): string
    {
        return route('demandes.download', [
            "grade" => $grade,
            "matricule" => $this->matricule,
            "demande" => $this,
        ]);
    }

    public function getReleveLinksAttribute()
    {
        $this->generateReleveLinks();
    }

    // releve links

    public function generateReleveLinks(): array
    {
        $links = [];
        foreach ($this->grades as $grade) {
            $links[$grade] = $this->generateReleveLink($grade);
        }
        return $links;
    }

    // releve links

    public function getRelevePrintAttribute()
    {
        $this->generateRelevePrintLink();
    }

    // generateReleveLinks

    public function generateRelevePrintLink(string $grade = "BAC3"): string
    {
        return route('demandes.print', [
            "grade" => $grade,
            "matricule" => $this->matricule,
            "demande" => $this,
        ]);
    }

    public function sendReleveLink(string $grade = "BAC1"): string
    {
        return route('demandes.send', [
            "grade" => $grade,
            "matricule" => $this->matricule,
            "demande" => $this,
        ]);
    }


    // get created_at attribute in human readable diff for now

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    // get status variant attribute
    public function getStatusVariantAttribute()
    {
        return $this->status->variant();
    }

    // get display status attribute
    public function getStatusDisplayAttribute()
    {
        return $this->status->label();
    }

    // is accepted
    public function isAccepted()
    {
        return $this->status->isAccepted();
    }

    // is rejected
    public function isRejected()
    {
        return $this->status->isRejected();
    }

    // get status message attribute
    public function getStatusMessageAttribute()
    {
        return $this->status->message();
    }

    // get releve_url attribute
    public function getReleveLinkAttribute()
    {
        return $this->releve_location;
    }

    // get status variant attribute


    // get faculte attribute

    public function faculte()
    {
        return $this->belongsTo(Faculte::class, 'faculte_code', 'code');
    }

    // facute nom attribute
    public function getFaculteNomAttribute()
    {
        return $this->faculte->nom ?? 'Inconnu';
    }

    // has valid matricule
    public function hasValidMatricule(): bool
    {
        // matricule is valid if it contains only digits and is not empty and has 10 characters
        return preg_match('/^[0-9]{10}$/', $this->matricule) && $this->matricule != '';
    }

    // set email attribute
    public function getEmailAttribute()
    {
        return $this->user->email ?? null;
    }

    // updated_at attribute
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    // get promotions attribute
    public function getPromotionsAttribute()
    {
        // grades is a json string so we need to decode
        return implode(',', $this->grades);
    }

    // get date naissance attribute
    public function getDateNaissanceAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }


}
