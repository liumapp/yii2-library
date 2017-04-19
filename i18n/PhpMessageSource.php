<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace liumapp\library\i18n;

use Yii;
use yii\i18n\MessageSource;

/**
 * PhpMessageSource represents a message source that stores translated messages in PHP scripts.
 *
 * PhpMessageSource uses PHP arrays to keep message translations.
 *
 * - Each PHP script contains one array which stores the message translations in one particular
 *   language and for a single message category;
 * - Each PHP script is saved as a file named as `[[basePath]]/LanguageID/CategoryName.php`;
 * - Within each PHP script, the message translations are returned as an array like the following:
 *
 * ```php
 * return [
 *     'original message 1' => 'translated message 1',
 *     'original message 2' => 'translated message 2',
 * ];
 * ```
 *
 * You may use [[fileMap]] to customize the association between category names and the file names.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class PhpMessageSource extends MessageSource
{
    /**
     * @var string the base path for all translated messages. Defaults to '@app/messages'.
     */
    public $basePath = '@app/messages';
    /**
     * @var array mapping between message categories and the corresponding message file paths.
     * The file paths are relative to [[basePath]]. For example,
     *
     * ```php
     * [
     *     'core' => 'core.php',
     *     'ext' => 'extensions.php',
     * ]
     * ```
     */
    public $fileMap;

    /**
     * @var string 缓存合并所有的方言
     */
    public $translationCachePrefix = 'phpMessageTranslation';

    /**
     * @var array mapping between message categories and the corresponding message file paths.
     * The file paths are relative to [[basePath]]. For example,
     * $basePath　最后加载
     * 文件靠前先加载，后面的文件的key覆盖前面的相同的key
     *
     * ```php
     * [
     *     '@vender/huluwa/admin/messages',
     *     '@vender/huluwa/common/messages',
     * ]
     * ```
     */
    public $dirMap = [];




    /**
     * Loads the message translation for the specified $language and $category.
     * If translation for specific locale code such as `en-US` isn't found it
     * tries more generic `en`. When both are present, the `en-US` messages will be merged
     * over `en`. See [[loadFallbackMessages]] for details.
     * If the $language is less specific than [[sourceLanguage]], the method will try to
     * load the messages for [[sourceLanguage]]. For example: [[sourceLanguage]] is `en-GB`,
     * $language is `en`. The method will load the messages for `en` and merge them over `en-GB`.
     *
     * @param string $category the message category
     * @param string $language the target language
     * @return array the loaded messages. The keys are original messages, and the values are the translated messages.
     * @see loadFallbackMessages
     * @see sourceLanguage
     */
    protected function loadMessages($category, $language)
    {

        $key = $this->translationCachePrefix . $category;
        if (YII_DEBUG || ! $messages = Yii::$app->cache->get($key )) {
            $messages = [];

            foreach($this->dirMap as $dir)
            {
                $messages = array_merge($messages,$this->loadMessagesByCategory($dir,$category,$language));
            }
            $messages = array_merge($messages,$this->loadMessagesByCategory($this->basePath,$category,$language));
            Yii::$app->cache->set($key,$messages);
        }

        return (array) $messages;
    }

    protected function loadMessagesByCategory($basePath,$category,$language)
    {
        $messageFile = $this->getMessageFilePath($basePath,$category, $language);
        $messages = $this->loadMessagesFromFile($messageFile);

        $fallbackLanguage = substr($language, 0, 2);
        $fallbackSourceLanguage = substr($this->sourceLanguage, 0, 2);

        if ($language !== $fallbackLanguage) {
            $messages = $this->loadFallbackMessages($basePath,$category, $fallbackLanguage, $messages, $messageFile);
        } elseif ($language === $fallbackSourceLanguage) {
            $messages = $this->loadFallbackMessages($basePath,$category, $this->sourceLanguage, $messages, $messageFile);
        } else {
            if ($messages === null) {
                Yii::error("The message file for category '$category' does not exist: $messageFile", __METHOD__);
            }
        }
        return (array) $messages;
    }

    /**
     * The method is normally called by [[loadMessages]] to load the fallback messages for the language.
     * Method tries to load the $category messages for the $fallbackLanguage and adds them to the $messages array.
     *
     * @param string $basePath;
     * @param string $category the message category
     * @param string $fallbackLanguage the target fallback language
     * @param array $messages the array of previously loaded translation messages.
     * The keys are original messages, and the values are the translated messages.
     * @param string $originalMessageFile the path to the file with messages. Used to log an error message
     * in case when no translations were found.
     * @return array the loaded messages. The keys are original messages, and the values are the translated messages.
     * @since 2.0.7
     */
    protected function loadFallbackMessages($basePath,$category, $fallbackLanguage, $messages, $originalMessageFile)
    {
        $fallbackMessageFile = $this->getMessageFilePath($basePath,$category, $fallbackLanguage);
        $fallbackMessages = $this->loadMessagesFromFile($fallbackMessageFile);

        if (
            $messages === null && $fallbackMessages === null
            && $fallbackLanguage !== $this->sourceLanguage
            && $fallbackLanguage !== substr($this->sourceLanguage, 0, 2)
        ) {
            Yii::error("The message file for category '$category' does not exist: $originalMessageFile "
                . "Fallback file does not exist as well: $fallbackMessageFile", __METHOD__);
        } elseif (empty($messages)) {
            return $fallbackMessages;
        } elseif (!empty($fallbackMessages)) {
            foreach ($fallbackMessages as $key => $value) {
                if (!empty($value) && empty($messages[$key])) {
                    $messages[$key] = $fallbackMessages[$key];
                }
            }
        }

        return (array) $messages;
    }

    /**
     * Returns message file path for the specified language and category.
     * @param string $basePath
     * @param string $category the message category
     * @param string $language the target language
     * @return string path to message file
     */
    protected function getMessageFilePath($basePath,$category, $language)
    {
        $messageFile = Yii::getAlias($basePath) . "/$language/";
        if (isset($this->fileMap[$category])) {
            $messageFile .= $this->fileMap[$category];
        } else {
            $messageFile .= str_replace('\\', '/', $category) . '.php';
        }

        return $messageFile;
    }

    /**
     * Loads the message translation for the specified language and category or returns null if file doesn't exist.
     *
     * @param string $messageFile path to message file
     * @return array|null array of messages or null if file not found
     */
    protected function loadMessagesFromFile($messageFile)
    {
        if (is_file($messageFile)) {
            $messages = include($messageFile);
            if (!is_array($messages)) {
                $messages = [];
            }

            return $messages;
        } else {
            return null;
        }
    }
}
