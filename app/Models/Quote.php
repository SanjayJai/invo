<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Quote extends Model
{
    use HasFactory;

    const SELECT_DISCOUNT_TYPE = 0;
    const FIXED = 1;
    const PERCENTAGE = 2;

    const DISCOUNT_TYPE = [
        self::SELECT_DISCOUNT_TYPE => 'Select Discount Type',
        self::FIXED => 'Fixed',
        self::PERCENTAGE => 'Percentage',
    ];

    const DRAFT = 0;
    const CONVERTED = 1;
    const STATUS_ALL = 2;

    const STATUS_ARR = [
        self::DRAFT => 'Draft',
        self::CONVERTED => 'Converted',
        self::STATUS_ALL => 'All',
    ];

    const MONTHLY = 1;
    const QUARTERLY = 2;
    const SEMIANNUALLY = 3;
    const ANNUALLY = 4;

    const RECURRING_ARR = [
        self::MONTHLY => 'Monthly',
        self::QUARTERLY => 'Quarterly',
        self::SEMIANNUALLY => 'Semi Annually',
        self::ANNUALLY => 'Annually',
    ];

    protected $table = 'quotes';

    protected $with = ['quoteItems.product'];

    protected $casts = [
        'client_id' => 'integer',
        'quote_date' => 'date',
        'due_date' => 'date',
        'quote_id' => 'string',
        'amount' => 'double',
        'discount_type' => 'integer',
        'discount' => 'double',
        'final_amount' => 'double',
        'note' => 'string',
        'term' => 'string',
        'template_id' => 'integer',
        'status' => 'integer',
        'recurring' => 'integer',
    ];

    protected $fillable = [
        'client_id',
        'quote_date',
        'due_date',
        'quote_id',
        'amount',
        'discount_type',
        'discount',
        'final_amount',
        'note',
        'term',
        'template_id',
        'status',
    ];

    protected $appends = ['status_label'];

    public static $rules = [
        'client_id' => 'required',
        'quote_id' => 'required|unique:quotes,quote_id',
        'quote_date' => 'required',
        'due_date' => 'required',
    ];

    public static $messages = [
        'client_id.required' => 'The Client field is required.',
        'quote_date.required' => 'The Quote date field is required.',
        'due_date.required' => 'The Quote Due date field is required.',
    ];

    /** Relationships */

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function quoteItems(): HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function invoiceTemplate(): BelongsTo
    {
        return $this->belongsTo(InvoiceSetting::class, 'template_id', 'id');
    }

    public function adminPayments(): HasMany
    {
        return $this->hasMany(AdminPayment::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /** Accessors & Mutators */

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_ARR[$this->status] ?? 'Unknown';
    }

    public function setQuoteDateAttribute($value)
    {
        $this->attributes['quote_date'] = Carbon::createFromFormat(currentDateFormat(), $value)->format('Y-m-d');
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = Carbon::createFromFormat(currentDateFormat(), $value)->format('Y-m-d');
    }

    /** Utility */

    public static function generateUniqueQuoteId(): string
    {
        do {
            $quoteId = mb_strtoupper(Str::random(6));
        } while (self::where('quote_id', $quoteId)->exists());

        return $quoteId;
    }
}
