<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 19-1-8
 * Time: 上午9:14
 */

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasySwoole\WeChat\OfficialAccount;

use finfo;
use Swoole\Coroutine;

/**
 * Class File.
 */
class File
{
    /**
     * MIME mapping.
     *
     * @var array
     */
    const EXTENSION_MAP = [
        'audio/wav' => '.wav',
        'audio/x-ms-wma' => '.wma',
        'video/x-ms-wmv' => '.wmv',
        'video/mp4' => '.mp4',
        'audio/mpeg' => '.mp3',
        'audio/amr' => '.amr',
        'application/vnd.rn-realmedia' => '.rm',
        'audio/mid' => '.mid',
        'image/bmp' => '.bmp',
        'image/gif' => '.gif',
        'image/png' => '.png',
        'image/tiff' => '.tiff',
        'image/jpeg' => '.jpg',
        'application/pdf' => '.pdf',

        // 列举更多的文件 mime, 企业号是支持的,公众平台这边之后万一也更新了呢
        'application/msword' => '.doc',

        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template' => '.dotx',
        'application/vnd.ms-word.document.macroEnabled.12' => '.docm',
        'application/vnd.ms-word.template.macroEnabled.12' => '.dotm',

        'application/vnd.ms-excel' => '.xls',

        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '.xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template' => '.xltx',
        'application/vnd.ms-excel.sheet.macroEnabled.12' => '.xlsm',
        'application/vnd.ms-excel.template.macroEnabled.12' => '.xltm',
        'application/vnd.ms-excel.addin.macroEnabled.12' => '.xlam',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12' => '.xlsb',

        'application/vnd.ms-powerpoint' => '.ppt',

        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => '.pptx',
        'application/vnd.openxmlformats-officedocument.presentationml.template' => '.potx',
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow' => '.ppsx',
        'application/vnd.ms-powerpoint.addin.macroEnabled.12' => '.ppam',
    ];

    /**
     * File header signatures.
     *
     * @var array
     */
    const SIGNATURES = [
        'ffd8ff' => '.jpg',
        '424d' => '.bmp',
        '47494638' => '.gif',
        '2f55736572732f6f7665' => '.png',
        '89504e47' => '.png',
        '494433' => '.mp3',
        'fffb' => '.mp3',
        'fff3' => '.mp3',
        '3026b2758e66cf11' => '.wma',
        '52494646' => '.wav',
        '57415645' => '.wav',
        '41564920' => '.avi',
        '000001ba' => '.mpg',
        '000001b3' => '.mpg',
        '2321414d52' => '.amr',
        '25504446' => '.pdf',
    ];

    /**
     * Return steam extension.
     *
     * @param string $stream
     *
     * @return string|false
     */
    public static function getStreamExt($stream)
    {
        try {
            // 考虑用户可能传递的是 path 而非 stream
            if (is_readable($stream)) {
                $stream = Coroutine::readFile($stream);
            }
        } catch (\Exception $e) {
        }

        $mime = self::getStreamMimeType($stream);

        return self::EXTENSION_MAP[$mime] ?? self::getExtBySignature($stream);
    }

    /**
     * getStreamMimeType
     *
     * @param $stream
     * @return string
     */
    public static function getStreamMimeType($stream)
    {
        $fileInfo = new finfo(FILEINFO_MIME);
        return strstr($fileInfo->buffer($stream), ';', true);
    }


    /**
     * Get file extension by file header signature.
     *
     * @param string $stream
     *
     * @return string
     */
    public static function getExtBySignature($stream)
    {
        $prefix = strval(bin2hex(mb_strcut($stream, 0, 10)));

        foreach (self::SIGNATURES as $signature => $extension) {
            if (0 === strpos($prefix, strval($signature))) {
                return $extension;
            }
        }

        return '';
    }
}