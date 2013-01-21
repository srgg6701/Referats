<?php 
// ������ ������ �� RTF 
// ������ 0.2 
// �����: ������� ������ a.k.a Ramon 
// E-mail: alex@rembish.ru 
// Copyright 2009 

// �������, ������� ���������, �������� �� ������, � �������� �� ������ �������� 
// ��������� �� ����� �������. ������� � ������ ����� ����� - � ������� failAt 
// �������� �� �������� ����� ��� �������� ��������� �����, ������� ����������, 
// ��� ����� ���� ���-�� ������, � �� ����� - ��������, �� ����� ���� �������� 
// ������� ��� �������� �������. � ��� �����. 
function rtf_isPlainText($s) { 
    $failAt = array("*", "fonttbl", "colortbl", "datastore", "themedata"); 
    for ($i = 0; $i < count($failAt); $i++) 
        if (!empty($s[$failAt[$i]])) return false; 
    return true; 
} 
function rtf2text($filename) { 
    // �������� ������� ������ �� ����������� ��� rtf-�����, � ������ ������ - 
    // ���������� ���� ����������� ����. 
	//
    $text = file_get_contents($filename);
	if ($text==false) {
		$Tools->setCHMODE ($filename);
		$this->data = file_get_contents($filename);
	}	
	 
    if (!strlen($text)) 
        return ""; 


    // ����, ����� ������� ��� ������ ������ �� rtf'� - ��� ������� ��������� 
    // ����� �������������. �������� ��, �����������, � ������� ����� � �������������� 
    // ��� (�����) ������. 
    $document = ""; 
    $stack = array(); 
    $j = -1; 

    // ������ ����������� ������... 
    for ($i = 0, $len = strlen($text); $i < $len; $i++) { 
        $c = $text[$i]; 

        // ������ �� �������� ������� ��������, ��� �� � ������� ����� ������. 
        switch ($c) { 
            // ����, ����� ������ ���� "�������� ����" 
            case "\\": 
                // ������ ��������� ������, ����� ������, ��� ��� ������ ������ 
                $nc = $text[$i + 1]; 

                // ���� ��� ������ �������, ��� ����������� ������, ��� ������������ 
                // �����, �� �� ��������� ��������������� ������ � �������� ����� 
                // (����� � �����, � ����� �������� ������ � ��� ������, ���� ����� 
                // ���� ������ �����, � �� ��������� �������, � �������). 
                if ($nc == '\\' && rtf_isPlainText($stack[$j])) $document .= '\\'; 
                elseif ($nc == '~' && rtf_isPlainText($stack[$j])) $document .= ' '; 
                elseif ($nc == '_' && rtf_isPlainText($stack[$j])) $document .= '-'; 
                // ���� ����� ���� ������ ��������, �� ������� ���������� � �� � ����. 
                elseif ($nc == '*') $stack[$j]["*"] = true; 
                // ���� �� ��������� �������, �� �� ������ ��������� ��� ��������� 
                // �������, ������� �������� hex-�� �������, ������� �� ������ 
                // �������� � ��� �������� �����. 
                elseif ($nc == "'") { 
                    $hex = substr($text, $i + 2, 2); 
                    if (rtf_isPlainText($stack[$j])) 
                        $document .= html_entity_decode("&#".hexdec($hex).";"); 
                    // �� ��������� ��� ������ �������, ������ �������� ���������. 
                    $i += 2; 
                // ��� ����� ���� �����, � ��� ������, ��� �� \ ��� ���������� ����� 
                // � �������� ��������� �������� ��������, ������� �� ������ ���������. 
                } elseif ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') { 
                    $word = ""; 
                    $param = null; 

                    // �������� ������ ������� �� ���������. 
                    for ($k = $i + 1, $m = 0; $k < strlen($text); $k++, $m++) { 
                        $nc = $text[$k]; 
                        // ���� ������� ������ ����� � �� ����� �� ���� ������� ����, 
                        // �� �� �� ��� ������ ����������� �����, ���� �� ���� �����, 
                        // �� �� ������������ �� ������ ������������ - �������� ����� 
                        // ��� ��� ����� �����������. 
                        if ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') { 
                            if (empty($param)) 
                                $word .= $nc; 
                            else 
                                break; 
                        // ���� ����� ���� �����, �� �������� ���������� �������� �����. 
                        } elseif ($nc >= '0' && $nc <= '9') 
                            $param .= $nc; 
                        // ����� ����� ���� ������ ����� �������� ����������, ������� 
                        // ��������� �������� �� ������� ��� � ��������� ������ 
                        // �� ������� �� ������� ����� � ����������. 
                        elseif ($nc == '-') { 
                            if (empty($param)) 
                                $param .= $nc; 
                            else 
                                break; 
                        // � ����� ������ ������ - �����. 
                        } else 
                            break; 
                    } 
                    // �������� ��������� �� ���������� ����������� ���� ����/����. 
                    $i += $m - 1; 

                    // �������� �����������, ��� �� �� ����� ��������. ��� ���������� 
                    // ������ ����������� �����. 
                    $toText = ""; 
                    switch (strtolower($word)) { 
                        // ���� ����� "u", �� �������� - ��� ���������� ������������� 
                        // unicode-�������, �� ������ �������� ��� � �����. 
                        // �� �� ������ ������, ��� �� �������� ����� ������ ��� 
                        // ������, � ������, ���� ��������� ����������� �� ����� �������� 
                        // � Unicode, ������� ��� ������� \ucN � �����, �� ������ �������� 
                        // "������" N �������� �� ��������� ������. 
                        case "u": 
                            $toText .= html_entity_decode("&#x".dechex($param).";"); 
                            $ucDelta = @$stack[$j]["uc"]; 
                            if ($ucDelta > 0) 
                                $i += $ucDelta; 
                        break; 
                        // ���������� �������� �����, ��������� ���� ��������, � ����� ������ 
                        // ���������. 
                        case "par": case "page": case "column": case "line": case "lbr": 
                            $toText .= "\n";  
                        break; 
                        case "emspace": case "enspace": case "qmspace": 
                            $toText .= " ";  
                        break; 
                        case "tab": $toText .= "\t"; break; 
                        // ������� ������ ��������������� ����� ������� ���� ��� �����. 
                        case "chdate": $toText .= date("m.d.Y"); break; 
                        case "chdpl": $toText .= date("l, j F Y"); break; 
                        case "chdpa": $toText .= date("D, j M Y"); break; 
                        case "chtime": $toText .= date("H:i:s"); break; 
                        // ������� ��������� ����������� �� �� html-�������. 
                        case "emdash": $toText .= html_entity_decode("&mdash;"); break; 
                        case "endash": $toText .= html_entity_decode("&ndash;"); break; 
                        case "bullet": $toText .= html_entity_decode("&#149;"); break; 
                        case "lquote": $toText .= html_entity_decode("&lsquo;"); break; 
                        case "rquote": $toText .= html_entity_decode("&rsquo;"); break; 
                        case "ldblquote": $toText .= html_entity_decode("&laquo;"); break; 
                        case "rdblquote": $toText .= html_entity_decode("&raquo;"); break; 
                        // �� ��������� ������� � ������� ���� ����������� ����. ���� � �������� 
                        // ����� ��� ����������, �� ���������� �������� true. 
                        default: 
                            $stack[$j][strtolower($word)] = empty($param) ? true : $param; 
                        break; 
                    } 
                    // ���� ���-�� ��������� ������� � �������� �����, �� �������, ���� ��� ���������. 
                    if (rtf_isPlainText($stack[$j])) 
                        $document .= $toText; 
                } 

                $i++; 
            break; 
            // ����� ���� ������ { - ������ ����������� ����� ���������, ������� �� ������ ������� 
            // ����� ������� ����� � ��������� �������� � ���������� �������. 
            case "{": 
                array_push($stack, $stack[$j++]); 
            break; 
            // ������������� �������� ������, ������� ������� ������� �� �����. ������ �����������. 
            case "}": 
                array_pop($stack); 
                $j--; 
            break; 
            // ������ ���������� �����������. 
            case '\0': case '\r': case '\f': case '\n': break; 
            // ���������, ���� ���������, ���������� �� �����. 
            default: 
                if (rtf_isPlainText($stack[$j])) 
                    $document .= $c; 
            break; 
        } 
    } 
    // ����������, ��� ��������. 
    return $document; 
}?> 
