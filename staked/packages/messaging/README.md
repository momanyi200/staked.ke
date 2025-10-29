// app/Models/User.php (add accessor if not exists)
public function getAvatarUrlAttribute()
{
    return $this->profile_photo 
        ? asset('storage/' . $this->profile_photo) 
        : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
}

public function conversations()
{
    return $this->belongsToMany(Conversation::class);
}

// app/Models/User.php
public function unreadMessages()
{
    return $this->belongsToMany(\YourName\Messaging\Models\Message::class, 'message_user')
                ->wherePivot('is_read', false);
}

public function unreadMessagesCount()
{
    return $this->unreadMessages()->count();
}




5. Register Package Locally

In your Laravel app’s composer.json:

"repositories": [
    {
        "type": "path",
        "url": "./packages/messaging"
    }
]

Then install
composer require yourname/messaging:@dev

6. Use in Your App

Run migrations: php artisan migrate

Visit /messaging → your module works 🎉
