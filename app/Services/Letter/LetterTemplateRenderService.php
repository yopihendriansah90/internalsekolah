<?php

namespace App\Services\Letter;

use App\Models\Letter;
use App\Models\LetterTemplate;

class LetterTemplateRenderService
{
    public function __construct(
        protected LetterPlaceholderService $placeholderService,
    ) {}

    /**
     * @return array{subject:string,content:string,placeholders:array<string,string>}
     */
    public function renderForLetter(Letter $letter): array
    {
        $template = $letter->template;
        $placeholders = $this->placeholderService->forLetter($letter);

        $subjectSource = $template?->subject_template ?: $letter->subject;
        $contentSource = $template?->body_html ?: $letter->content;

        return [
            'subject' => $this->replace((string) $subjectSource, $placeholders),
            'content' => $this->replace((string) $contentSource, $placeholders),
            'placeholders' => $placeholders,
        ];
    }

    /**
     * @param  array<string, string>  $values
     */
    public function replace(string $template, array $values): string
    {
        $map = [];

        foreach ($values as $key => $value) {
            $map["{{{$key}}}"] = $value;
            $map["[[{$key}]]"] = $value;
        }

        return strtr($template, $map);
    }
}
