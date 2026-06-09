import { Head } from '@inertiajs/react';
import GeneratedIdeaComponent from '@/components/generated-idea-component';
import { allIdeas } from '@/routes';
import type { GeneratedIdea } from '@/types/generated_idea';

interface ViewIdeaProps {
    generated_idea: GeneratedIdea;
}

export default function ViewIdea({ generated_idea }: ViewIdeaProps) {
    return (
        <>
            <Head title="Ideas" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="mb-4">
                    <GeneratedIdeaComponent
                        generated_idea={generated_idea}
                    ></GeneratedIdeaComponent>
                </div>
            </div>
        </>
    );
}

ViewIdea.layout = {
    breadcrumbs: [
        {
            title: 'Idea',
            href: null,
        },
    ],
};
