<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\OfficialAccount\Application;

/**
 * Class Card
 * @package EasySwoole\WeChat\OfficialAccount\Card
 * @property BoardingPassClient $boardingPass
 * @property CodeClient $code
 * @property GiftCardClient $giftCard
 * @property GiftCardOrderClient $giftCardOrder
 * @property GiftCardPageClient $giftCardPage
 * @property InvoiceClient $invoice
 * @property MeetingTicketClient $meetingTicket
 * @property MemberCardClient $memberCard
 * @property MovieTicketClient $movieTicket
 * @property SubMerchantClient $subMerchant
 */
class Card extends Client
{
    const BoardingPass = 'cardBoardingPass';
    const Code = 'cardCode';
    const GiftCard = 'cardGiftCard';
    const GiftCardOrder = 'cardGiftCardOrder';
    const GiftCardPage = 'cardGiftCardPage';
    const Invoice = 'cardInvoice';
    const MeetingTicket = 'cardMeetingTicket';
    const MemberCard = 'cardMemberCard';
    const MovieTicket = 'cardMovieTicket';
    const SubMerchant = 'cardSubMerchant';

    public function __get($property)
    {
        $key = Application::Card . ucfirst($property);
        if (isset($this->app[$key])) {
            return $this->app[$key];
        }

        throw new InvalidArgumentException(sprintf('No card service named "%s".', $property));
    }
}