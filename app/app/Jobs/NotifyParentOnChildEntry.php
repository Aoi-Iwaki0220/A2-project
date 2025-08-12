<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\Child; 
use App\Models\Message;
use App\Models\UserParent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyParentOnChildEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    protected $childId;

    public function __construct($childId, $type, $amount)
    {
        $this->childId = $childId;
        $this->type = $type;
        $this->amount = $amount;
    }

    public function handle(): void
    {
        
    $child = \App\Models\Child::find($this->childId);

    if (!$child) {
         Log::error("Child not found with id: " . $this->childId);
        // 子どもが見つからなければ終了
        return;
    }

    $parent = $child->parent;

    if (!$parent) {
        Log::warning("Parent not found for child id: " . $this->childId);
        return;
    }

        $messageText = $child->nickname . 'が' . 
                       ($this->type === 'income' ? '貰ったお金' : ($this->type === 'spend' ? '使ったお金' : '')). 
                       'を' . number_format($this->amount) . '円 登録しました。';

        Notification::create([
            'parent_id' => $parent->id,
        'type' => $this->type,  
        'message' => $messageText,
        ]);
    }
}
