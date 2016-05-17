<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Importer\Business\Importer\Glossary;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\Glossary\Persistence\SpyGlossaryKeyQuery;
use Pyz\Zed\Importer\Business\Importer\AbstractImporter;
use Spryker\Zed\Glossary\Business\GlossaryFacadeInterface;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;

class TranslationImporter extends AbstractImporter
{

    const TRANSLATIONS = 'translations';

    /**
     * @var \Spryker\Zed\Glossary\Business\GlossaryFacadeInterface
     */
    protected $glossaryFacade;

    /**
     * @param \Spryker\Zed\Locale\Business\LocaleFacadeInterface $localeFacade
     * @param \Spryker\Zed\Glossary\Business\GlossaryFacadeInterface $glossaryFacade
     */
    public function __construct(
        LocaleFacadeInterface $localeFacade,
        GlossaryFacadeInterface $glossaryFacade
    ) {
        parent::__construct($localeFacade);

        $this->glossaryFacade = $glossaryFacade;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Translation';
    }

    /**
     * @return bool
     */
    public function isImported()
    {
        $query = SpyGlossaryKeyQuery::create();
        return $query->count() > 0;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    protected function importOne(array $data)
    {
        foreach ($data as $translationKey => $translationData) {
            if (!$this->glossaryFacade->hasKey($translationKey)) {
                $this->glossaryFacade->createKey($translationKey);
            }

            foreach ($translationData[self::TRANSLATIONS] as $localeName => $translationText) {
                $localeTransfer = new LocaleTransfer();
                $localeTransfer->setLocaleName($localeName);

                if (!$this->glossaryFacade->hasTranslation($translationKey, $localeTransfer)) {
                    $this->glossaryFacade->createAndTouchTranslation($translationKey, $localeTransfer, $translationText, true);
                }
            }
        }
    }

}