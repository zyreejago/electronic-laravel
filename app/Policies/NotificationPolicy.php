namespace App\Policies;

use App\Models\Notification;
use App\Models\User;

class NotificationPolicy
{
    public function update(User $user, Notification $notification)
    {
        return $user->id === $notification->user_id;
    }
} 