<?php

namespace Arhitector\Yandex\Client\Event;

/**
 * Minimal event emitter (replaces league/event ^2 to avoid conflict with Passport / league/event ^3).
 */
class Emitter
{
	/**
	 * @var array<string, list<callable>>
	 */
	protected array $listeners = [];

	public function addListener(string $event, callable $listener): self
	{
		$this->listeners[$event][] = $listener;

		return $this;
	}

	public function removeListener(string $event, callable $listener): self
	{
		if (!isset($this->listeners[$event])) {
			return $this;
		}

		$this->listeners[$event] = array_values(array_filter(
			$this->listeners[$event],
			static fn ($item) => $item !== $listener
		));

		return $this;
	}

	public function removeAllListeners(?string $event = null): self
	{
		if ($event === null) {
			$this->listeners = [];
		} else {
			unset($this->listeners[$event]);
		}

		return $this;
	}

	public function hasListeners(?string $event = null): bool
	{
		if ($event === null) {
			foreach ($this->listeners as $list) {
				if ($list !== []) {
					return true;
				}
			}

			return false;
		}

		return !empty($this->listeners[$event]);
	}

	public function emit(string $event, ...$arguments): self
	{
		foreach ($this->listeners[$event] ?? [] as $listener) {
			$listener(...$arguments);
		}

		return $this;
	}
}
