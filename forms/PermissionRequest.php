<?php
class ForbesPurchaseForm_Form_PermissionRequest
    extends ForbesPurchaseFormLibrary_RequestBase
{
    public function init()
    {
        parent::init();
        $this->_addElements();
        $this->_addValidators();
        $this->_setRequiredElements();
    }

    protected function _addElements()
    {

        $this
            ->addElement('text', 'organization', array('label'=>__('Organization Name: ')))
            ->addElement('multiCheckbox', 'organizationstatus', array(
                'label'=>__('Organization Status: '),
                'multioptions'=>array(
                    'government'=>__('This organization is a Federal, State, or City Government agency'),
                    'non-profit'=>__('This organization is a 501(c)(3) non-profit'),
                    'public-access-tv'=>__('This organization is a public-access television station in Massachusetts')
                    )
                ))
            ->addElement('text', 'address', array('label'=>__('Mailing Address: ')))
            ->addElement('text', 'phone', array('label'=>__('Phone: ')))
            ->addElement('multiCheckbox', 'intendeduse', array(
                'label'=>__('Type of Use (check all that apply):'),
                'multioptions'=>array(
                    'personal'=>__('Personal Research (materials will not be copied, reproduced, or publicly displayed)'),
                    'public-display'=>__('Exhibitions or Public Display (includes display in offices, stores, resteraunts, lobbies, hotels'),
                    'book-illustration'=>__('Book Illustration (including text-books and scholarly titles)'),
                    'book-cover'=>__('Book Cover (including text-books and scholarly titles)'),
                    'academic'=>__('Academic (includes dissertations, theses, scholarly journals, and classroom use)'),
                    'periodical'=>__('Newspapers, Magazine, Newsletter, or Corporate Publication'),
                    'advertisement'=>__('Advertisment'),// $200
                    'non-editorial'=>__('Merchandise (Posters, Postcards, Calendars, Tee Shirts, Note Cards, etc.)'),
                    'cd-rom-video-software'=>__('CD/ROM, Video, or Software'),
                    'network-and-cable'=>__('Television Broadcast'),
                    'website'=>__('Website')
                    )
                ))
                ->addElement('textarea', 'description', array('label'=>__('Please provide a brief description of your intended use.'), 'cols' => '64', 'rows' => '3'))
                ->addElement('text', 'author', array('label'=>__('Author/Producer: ')))
                ->addElement('text', 'publisher', array('label'=>__('Publisher: ')))
                ->addElement('text', 'projected-publication-date', array('label'=>__('Projected Date of Publication: ')))
                ->addElement('text', 'estimated-print-run', array('label'=>__('Estimated Print Run: ')));
            $this
                //->addElement($captcha)
                ->addElement('submit', 'submit', array('label' => 'Submit'));
    }

    protected function _addValidators() {
        $this->getElement('email')->addValidator('EmailAddress', True);
    }

    protected function _setRequiredElements() {
        $this->getElement('name')->setRequired();
        $this->getElement('email')->setRequired();

    }
}

        /* fees - should go somewhere else
         * 'personal'=>// no fee
         * 'exhibitions-for-profit'=>__('Exhibition (for profit)'), // $25
         * 'exhibitions-non-profit'=>__('Exhibition (non profit. must have 501c3 status)'), // no fee
         * 'book-publication'=>__('Book Publication'),// inseid euse up to 5000 copies $25,  more $50, cover use up to 5000 copies $100, more $150
         * 'academic'=>__('Academic use (includes dissertations, theses, scholarly journals, and classroom use)'), // no fee
         * 'periodical'=>__('Newspapers, Magazine, and Newsletter/Corporate Publications'), // under 50,000 inside $25 cover $100, over 50,000 inside $50 cover $150
         * 'advertisement'=>__('Advertisment'),// $200
         * 'non-editorial'=>__('Posters, Postcards, Calendars, Tee Shirts, Note Cards, etc.'), // non profit $50, for profit $150
         * 'cd-rom-video-software'=>__('CD/ROM, Video, or Software'),// non profite $25, profit $50  per year
         * 'network-and-cable'=>__('Tevelivsion Broadcast (Network and Cable)'),// $75
         * 'public-tv'=>__('Public or non-profit television'),//$25
         * 'local-tv'=>__('Local television'),//no fee
         * 'personal-website'=>__('Personal Website'), // 25 per year
         * 'non-profit-website'=>__('Non Profit Wbsite'), // 25 per year
         * 'commerical-website'=>__('Commerical Website') // 50 per year
         * multimedia (more than on medium) $250
         */
