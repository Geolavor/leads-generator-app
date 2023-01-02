<template>
    <div class="d-grid gap-3">
        <h2>{{ title }}</h2>
        <div class="accordion accordion-flush accordion-lg" id="accordionFAQBasics">
            <div class="accordion-item" v-for="(item, index) in list" :key="index">
                <div class="accordion-header" id="headingBasicsOne" @click="activeItem(index)">
                    <a class="accordion-button" role="button" :class="active === index ? '' : 'collapsed'">
                        {{ item.title }}
                    </a>
                </div>
                <div id="collapseBasicsOne" class="accordion-collapse collapse" :class="active === index ? 'show' : ''">
                    <div class="accordion-body">
                        {{ item.description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        title: {
            type: String
        }
    },
    data() {
        return {
            active: null,
            list: [
                {
                    title: 'What do unlimited verifications mean?',
                    description: 'We enable fully free verification of e-mail addresses, and when searching for new data, we automatically verify contact details for free. You only pay for obtaining the data and all the rest is free.'
                },
                {
                    title: 'How does live search work?',
                    description: 'After creating a search, our robot searches the internet in real time. We do not use any ready-made databases, so you always have access to the best data.'
                },
                {
                    title: 'Can I integrate with my own CRM?',
                    description: 'At the moment, we do not have any integrations available, but we are open to recommendations of software with which we could connect.'
                },
                {
                    title: 'How does your artificial intelligence work?',
                    description: 'When searching data, our technology selects websites and obtained data in an innovative way.'
                },
                {
                    title: 'What is searching by locations?',
                    description: 'We have introduced a new innovative way of obtaining data through locations. The assumption is that you can obtain data from a specific location in which you run your business or which you simply care about.'
                },
                {
                    title: 'How do you care for security?',
                    description: `Our AI robot only analyzes public web pages and navigates at a slow pace. It never visits more than one page every two seconds for a website to make sure other visitors arent slowed down by the crawling.
                    We are respect robots.txt file. The robot strictly respect robots.txt, both disallow and allow rules (we do not, however, support nonstandard extensions unless stated otherwise).`
                }
            ]
        }
    },
    methods: {
        activeItem(index) {
            this.active == index ? this.active = null : this.active = index
        }
    }
}
</script>
