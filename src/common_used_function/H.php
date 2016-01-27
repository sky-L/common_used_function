<?php
namespace skylee;

class H
{

    /**
     * 生成短连接
     * @param string $url
     * @return string
     * 原理：
        1.将原网址做crc32校验，得到校验码。
        2.使用sprintf('%u') 将校验码转为无符号数字。
        3.对无符号数字进行求余62操作（大小写字母+数字等于62位），得到余数后映射到62个字符中，将映射后的字符保存。（例如余数是10，则映射的字符是A，0-9对应0-9，10-35对应A-Z，36-61对应a-z）
        4.循环操作，直到数值为0。
        5.将所有映射后的字符拼接，就是短网址后的code。
     */
    public static function short_url($url = "")
    {
        $code = sprintf('%u', crc32($url));
        
        $surl = '';
        
        while ($code)
        {
            $mod = $code % 62;
            
            if ($mod > 9 && $mod <= 35)
            {
                $mod = chr($mod + 55);
            }
            elseif ($mod > 35)
            {
                $mod = chr($mod + 61);
            }
            
            $surl .= $mod;
            
            $code = floor($code / 62);
        }
        
        return $surl;
    }


    public function date_friendly($timestamp, $time_limit = 604800, $out_format = 'Y-m-d H:i', $formats = null, $time_now = null)
    {
        if (!$timestamp) {
            return false;
        }
    
        if ($formats == null) {
            $formats = array('YEAR' => AWS_APP::lang()->_t('%s 年前'), 'MONTH' => AWS_APP::lang()->_t('%s 月前'), 'DAY' => AWS_APP::lang()->_t('%s 天前'), 'HOUR' => AWS_APP::lang()->_t('%s 小时前'), 'MINUTE' => AWS_APP::lang()->_t('%s 分钟前'), 'SECOND' => AWS_APP::lang()->_t('%s 秒前'));
        }
    
        $time_now = $time_now == null ? time() : $time_now;
        $seconds = $time_now - $timestamp;
    
        if ($seconds == 0) {
            $seconds = 1;
        }
    
        if (!$time_limit OR $seconds > $time_limit) {
            return date($out_format, $timestamp);
        }
    
        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $months = floor($days / 30);
        $years = floor($months / 12);
    
        if ($years > 0) {
            $diffFormat = 'YEAR';
        } else {
            if ($months > 0) {
                $diffFormat = 'MONTH';
            } else {
                if ($days > 0) {
                    $diffFormat = 'DAY';
                } else {
                    if ($hours > 0) {
                        $diffFormat = 'HOUR';
                    } else {
                        $diffFormat = ($minutes > 0) ? 'MINUTE' : 'SECOND';
                    }
                }
            }
        }
    
        $dateDiff = null;
    
        switch ($diffFormat) {
        	case 'YEAR' :
        	    $dateDiff = sprintf($formats[$diffFormat], $years);
        	    break;
        	case 'MONTH' :
        	    $dateDiff = sprintf($formats[$diffFormat], $months);
        	    break;
        	case 'DAY' :
        	    $dateDiff = sprintf($formats[$diffFormat], $days);
        	    break;
        	case 'HOUR' :
        	    $dateDiff = sprintf($formats[$diffFormat], $hours);
        	    break;
        	case 'MINUTE' :
        	    $dateDiff = sprintf($formats[$diffFormat], $minutes);
        	    break;
        	case 'SECOND' :
        	    $dateDiff = sprintf($formats[$diffFormat], $seconds);
        	    break;
        }
    
        return $dateDiff;
    }



}