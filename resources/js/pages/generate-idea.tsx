import { Form, Head, useForm, usePage } from '@inertiajs/react';
import { generateIdea } from '@/routes';
import { submit } from '@/routes/generate-idea';

export default function GenerateIdea() {
    const form = useForm({
        idea: '',
        notes: '',
        model: 'openai/gpt-5.4-mini',
        temperature: 1,
        useDefaultTemp: true,
        public: true,
    });

    const { data, setData } = form;
    const { flash } = usePage();
    console.log(flash);

    return (
        <>
            <Head title="Generate" />
            <div
                className={
                    'mt-8 mb-2 self-center rounded bg-red-800 px-4 py-4 text-center ' +
                    (flash['idea-generation-error'] === true ? '' : 'hidden')
                }
            >
                There was an error generating your idea, this has been logged.
                Please try again later.
            </div>
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Form
                    method="POST"
                    action={submit()}
                    autoComplete="off"
                    className="mx-auto flex w-3/4 flex-col items-center lg:w-1/2"
                    disableWhileProcessing
                >
                    {({ processing }) => (
                        <>
                            <div className="">
                                <div className="mb-4 text-xl">
                                    Generate SaaS Idea
                                </div>
                            </div>
                            <label
                                htmlFor="idea"
                                className="text-heading mb-2.5 block text-sm font-medium"
                            >
                                Idea summary
                            </label>
                            <input
                                type="text"
                                id="idea"
                                name="idea"
                                className="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand placeholder:text-body mb-4 block w-full border px-3 py-2.5 text-sm shadow-xs"
                                placeholder=""
                                required
                            />
                            <label
                                htmlFor="idea"
                                className="text-heading mb-2.5 block text-sm font-medium"
                            >
                                Notes / details
                            </label>
                            <textarea
                                rows={3}
                                id="notes"
                                name="notes"
                                className="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand placeholder:text-body mb-4 block w-full border px-3 py-2.5 text-sm shadow-xs"
                                placeholder=""
                            />
                            <label
                                htmlFor="model"
                                className="text-heading mb-2.5 block text-sm font-medium"
                            >
                                AI Model
                            </label>
                            <select
                                id="model"
                                name="model"
                                className="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand placeholder:text-body mb-4 block w-full border px-3 py-2.5 text-sm shadow-xs"
                                required
                            >
                                <option
                                    value=""
                                    disabled
                                    selected
                                    className="bg-neutral-secondary-medium text-heading"
                                >
                                    Please select
                                </option>
                                <option
                                    value="openai/gpt-5.4-mini"
                                    className="bg-neutral-secondary-medium text-heading"
                                >
                                    OpenAI GPT 5.4 Mini
                                    {/*(Mar 2026)*/}
                                </option>
                                <option
                                    value="anthropic/claude-haiku-4.5"
                                    className="bg-neutral-secondary-medium text-heading"
                                >
                                    Anthropic Claude Haiku 4.5
                                    {/*(Oct 2025)*/}
                                </option>
                                <option value="google/gemini-3.1-flash-lite">
                                    Google Gemini 3.1 Flash Lite
                                    {/*(May 2026)*/}
                                </option>
                                <option value="deepseek/deepseek-v4-flash">
                                    DeepSeek V4 Flash
                                    {/*(Apr 2026)*/}
                                </option>
                                <option value="ibm-granite/granite-4.1-8b">
                                    IBM Granite 4.1 8B
                                    {/*(Apr 2026)*/}
                                </option>
                                <option value="microsoft/phi-4-mini-instruct">
                                    Microsoft Phi 4 Mini Instruct
                                    {/*(Oct 2025)*/}
                                </option>
                                <option value="meta-llama/llama-4-maverick">
                                    Meta Llama 4 Maverick
                                    {/*(Apr 2025)*/}
                                </option>
                                <option value="x-ai/grok-4.3">
                                    xAI Grok 4.3
                                    {/*(May 2026)*/}
                                </option>
                            </select>
                            <label
                                htmlFor="temperature"
                                className="text-heading mb-2.5 block text-sm font-medium"
                            >
                                LLM Temperature
                            </label>
                            <label className="mb-2 flex items-center gap-2 text-sm">
                                <input
                                    type="checkbox"
                                    name="use-default-temperature"
                                    checked={data.useDefaultTemp}
                                    value="true"
                                    onChange={(e) =>
                                        setData(
                                            'useDefaultTemp',
                                            e.target.checked,
                                        )
                                    }
                                />
                                Use default
                            </label>
                            <div
                                className={
                                    'flex w-full flex-col items-center ' +
                                    (data.useDefaultTemp ? 'hidden' : '')
                                }
                            >
                                <input
                                    id="temperature"
                                    type="range"
                                    name="temperature"
                                    min={0}
                                    max={1.4}
                                    step={0.1}
                                    value={data.temperature}
                                    onChange={(e) =>
                                        setData(
                                            'temperature',
                                            parseFloat(e.target.value),
                                        )
                                    }
                                    className="w-30/31 disabled:opacity-40"
                                />
                                <div className="grid w-full grid-cols-15 text-center">
                                    <div>0</div>
                                    <div></div>
                                    <div>0.2</div>
                                    <div></div>
                                    <div>0.4</div>
                                    <div></div>
                                    <div>0.6</div>
                                    <div></div>
                                    <div>0.8</div>
                                    <div></div>
                                    <div>1</div>
                                    <div></div>
                                    <div>1.2</div>
                                    <div></div>
                                    <div>1.4</div>
                                </div>
                            </div>
                            <label
                                htmlFor="temperature"
                                className="text-heading mb-2.5 block text-sm font-medium"
                            >
                                Visibility
                            </label>
                            <label
                                className="mb-0 flex items-center gap-2 text-sm"
                                htmlFor="public"
                            >
                                <input
                                    id="public"
                                    type="checkbox"
                                    name="public"
                                    checked={data.public}
                                    value="true"
                                    onChange={(e) =>
                                        setData('public', e.target.checked)
                                    }
                                />
                                Public
                            </label>
                            <div>(visible to all users in "All Ideas")</div>
                            <div className="mt-6">
                                <div className="self-center">
                                    <button
                                        type="submit"
                                        className={`rounded-xl px-4 py-2 ${processing ? 'bg-green-900' : 'cursor-pointer bg-green-700'}`}
                                    >
                                        {processing
                                            ? 'Generating...'
                                            : 'Generate'}
                                    </button>
                                </div>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </>
    );
}

GenerateIdea.layout = {
    breadcrumbs: [
        {
            title: 'Generate Idea',
            href: generateIdea(),
        },
    ],
};
