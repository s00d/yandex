<?php

namespace Arhitector\Yandex\Client\Event;

trait EmitterTrait
{
	protected ?Emitter $emitter = null;

	public function setEmitter(?Emitter $emitter = null): self
	{
		$this->emitter = $emitter;

		return $this;
	}

	public function getEmitter(): Emitter
	{
		if ($this->emitter === null) {
			$this->emitter = new Emitter();
		}

		return $this->emitter;
	}

	public function addListener(string $event, callable $listener): self
	{
		$this->getEmitter()->addListener($event, $listener);

		return $this;
	}

	public function emit(string $event, ...$arguments): self
	{
		$this->getEmitter()->emit($event, ...$arguments);

		return $this;
	}
}
