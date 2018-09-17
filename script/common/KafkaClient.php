<?php
use \RdKafka\Exception;

class KafkaClient {

    private static $instance = null;

    final private function __construct($config){
        $this->config = $config;

        $rdConf = new \RdKafka\Conf();
        $rdConf->set('enable.auto.commit', 'false');
        $rdConf->set('metadata.broker.list', $this->config['broker']);
        $rdConf->set('group.id', $this->config['group']);

        $this->rdConf = $rdConf;

        $topicConf = new \RdKafka\TopicConf();
        $topicConf->set('auto.offset.reset', 'smallest');
        $this->topicConf = $topicConf;
    }

    public static function getInstance($config){
        if (null === self::$instance) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function getHighConsumer() {
        $consumer = new \RdKafka\KafkaConsumer($this->rdConf);
        $consumer->subscribe([$this->config['topic']]);
        $this->highConsumer = $consumer;
        return $consumer;
    }

    public function consumeOne($partition, $offset){
        $this->highConsumer->unsubscribe();
        $this->highConsumer->assign([
            new \RdKafka\TopicPartition($this->config['topic'], $partition, $offset),
        ]);
        $msg = $this->highConsumer->consume(120*1000);
        return $msg;
    }

    private function __clone(){}

}


