<?php

namespace App\Http\Livewire\Scolarite\Eleve;


use App\Models\Eleve;
use App\Models\Presence;
use DateTime;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use SmirlTech\LaravelFullcalendar\Calendar;
use SmirlTech\LaravelFullcalendar\SimpleEvent;

class PresenceComponent extends Component
{
    public string $calendar_script;
    public string $calendar_view;
    private Calendar $calendar;

    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.eleves.presence-component');
    }

    // mount
    public function mount(Eleve $eleve)
    {
        $events[] = new SimpleEvent(
            'Event One', //event title
            false, //full day event?
            '2015-02-11T0800', //start time (you can also use Carbon instead of DateTime)
            '2015-02-12T0800', //end time (you can also use Carbon instead of DateTime)
            0 //optionally, you can specify an event ID
        );

        $events[] = new SimpleEvent(
            "Valentine's Day", //event title
            true, //full day event?
            new DateTime('2015-02-14'), //start time (you can also use Carbon instead of DateTime)
            new DateTime('2015-02-14'), //end time (you can also use Carbon instead of DateTime)
            'stringEventId' //optionally, you can specify an event ID
        );

        $eloquentEvent = Presence::first(); //EventModel implements SmirlTech\LaravelFullcalendar\Event

        $this->calendar = \Calendar::addEvents($events)->setOptions([ //set fullcalendar options
            'initialView' => 'dayGridMonth',
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'viewRender' => 'function() {alert("Callbacks!");}'
        ]);

        $this->calendar_view = $this->calendar->calendar();
        $this->calendar_script = $this->calendar->scriptToHtml();
    }
}
