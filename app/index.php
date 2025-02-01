<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Bref\Context\Context;
use Bref\Event\EventBridge\EventBridgeEvent;
use Bref\Event\EventBridge\EventBridgeHandler;
use NtimYeboah\Owura\Payload\EventBridgePayload;
use NtimYeboah\PhpSlack\BlockKit\Blocks\Context as BlocksContext;
use NtimYeboah\PhpSlack\BlockKit\Blocks\Header;
use NtimYeboah\PhpSlack\BlockKit\Blocks\Section;
use NtimYeboah\PhpSlack\SlackMessage;
use \RuntimeException;

class EventHandler extends EventBridgeHandler
{
    public function handleEventBridge(EventBridgeEvent $event, Context $context): void
    {
        $payload = EventBridgePayload::capture($event->getDetail());

        $response = (new SlackMessage)
            ->token(getenv('SLACK_BOT_USER_TOKEN'))
            ->channel(getenv('SLACK_CHANNEL'))
            ->header(function (Header $header) use ($payload) {
                $header->text("New event happened in your AWS Account: {$payload->user()->awsAccountId()}");
            })
            ->context(function (BlocksContext $context) use ($payload) {
                $context->text("{$payload->user()->name()} performed a new action in your AWS Account.");
            })
            ->section(function (Section $section) use ($payload) {
                $section->field("*IAM User:*\n<https://{$payload->console()->region()}.console.aws.amazon.com/iam/home?region={$payload->console()->region()}#/users/details/{$payload->user()->name()}|{$payload->user()->name()}>")->markdown()
                    ->field("*Source IP Address:*\n{$payload->session()->sourceIpAddress()}")->markdown();
            })
            ->section(function (Section $section) use ($payload) {
                $section->field("*AWS Account:*\n<https://{$payload->console()->region()}.console.aws.amazon.com/console/home?region={$payload->console()->region()}#|{$payload->console()->recipientAccountId()}>")->markdown()
                    ->field("*AWS Region:*\n{$payload->console()->region()}")->markdown();
            })
            ->section(function (Section $section) use ($payload) {
                $section->field("*Event Name:*\n{$payload->event()->name()}")->markdown()
                    ->field("*Event Source:*\n{$payload->event()->source()}")->markdown();
            })
            ->section(function (Section $section) use ($payload) {
                $section->field("*Event Time:*\n{$payload->event()->time()->format('l, F j, Y')}\n")->markdown();
            })
            ->divider()
            ->section(function (Section $section) use ($payload) {
                $section->field("*<https://{$payload->console()->region()}.console.aws.amazon.com/cloudtrailv2/home?region={$payload->console()->region()}#/events/{$payload->event()->id()}|View in Cloudtrail>*")->markdown();
            })
            ->divider()
            ->send();

        $responseBody = $response->getBody();
        $responseContents = json_decode($responseBody->getContents());

        if ($response->getStatusCode() === 200 && $responseContents->ok === false) {
            throw new RuntimeException('Slack API call failed with error ['.$responseContents->error.'].');
        }
    }
}

return new EventHandler();
