<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Event::class;
    protected int | string | array $columnSpan = 2;

    public ?array $data = [];

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'prev,today,next',
                'center' => 'title',
                'right' => 'dayGridWeek,dayGridDay,dayGridMonth',
            ],
        ];
    }

    protected function getEventColor(Event $event): string
    {
        return match ($event->status) {
            'pending' => '#ffa500', // Orange
            'approved' => '#26ff00', // Green
            'on-going' => '#3788d8', // Blue
            'done' => '#45cc80', // Green
            'canceled' => '#ff0000', // Red
            default => '#000000', // Blue
        };
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make()
                ->mountUsing(
                    function (Form $form, array $arguments) {
                        $form->fill([
                            'starts_at' => $arguments['start'] ?? null,
                            'ends_at' => $arguments['end'] ?? null,
                            'user_id' => auth()->id(),
                            'status'=> 'pending'
                        ]);
                    }
                )
        ];
    }

    protected function modalActions(): array
    {
        return [
            \Filament\Actions\Action::make('edit')
                ->modalHeading(function($record) {
                    $user_name = User::find($record->user_id)?->name;
                    return new HtmlString("<strong>Edit Event $record->user_id</strong> <small>(created by: <i>$user_name</i>)</small>");
                 })
                ->form($this->getFormSchema())
                ->fillForm(function ($record){
                    return [
                        'name' => $record->name,
                        'starts_at' => $record->starts_at,
                        'ends_at' => $record->ends_at,
                        'user_id' => $record->user_id,
                        'status' => $record->status,
                    ];
                })
                ->action(function (array $data, Event $record): void {
                    $record->update($data);
                    Notification::make()
                        ->title('Notification')
                        ->success()
                        ->body('Event updated successfully. 🎉🎉🎉')
                        ->send();
                    $this->js('window.location.reload()');
                }),
            \Filament\Actions\Action::make('delete')
                ->requiresConfirmation()
                ->action(fn (Event $record) => $record->delete())
                ->color('danger'),
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
//            ->where('starts_at', '>=', $fetchInfo['start'])
//            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Event $event) => [
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => $event->starts_at,
                    'end' => $event->ends_at,
//                    'url' => EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                    'shouldOpenUrlInNewTab' => true,
                    'backgroundColor' => $this->getEventColor($event),
                ]
            )
            ->all();
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }) {
            let startTime = event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
            let endTime = event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

            let title = event.title + " (" + startTime + " - " + endTime + ")";

            el.setAttribute("x-tooltip", "tooltip");
            el.setAttribute("x-data", `{ tooltip: "\${title}" }`);
        }
    JS;
    }


    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required(),
            DateTimePicker::make('starts_at')
                ->required()
                ->seconds(false)
                ->default(now()),
            DateTimePicker::make('ends_at')
                ->required()
                ->seconds(false)
                ->default(now()),
            Hidden::make('user_id')
                ->default(auth()->id()),
            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'on-going' => 'On-Going',
                    'done' => 'Done',
                    'canceled' => 'Canceled',
                ])
                ->default('pending'),
        ];
    }
}
