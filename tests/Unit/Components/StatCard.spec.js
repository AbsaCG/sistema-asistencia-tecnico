import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import StatCard from '@/Components/StatCard.vue';

describe('StatCard Component', () => {
  it('renders correctly with default props', () => {
    const wrapper = mount(StatCard, {
      props: {
        label: 'Total Estudiantes',
        value: 42,
        icon: 'users',
        type: 'default',
      },
    });

    expect(wrapper.text()).toContain('Total Estudiantes');
    expect(wrapper.text()).toContain('42');
  });

  it('applies success color when type is success', () => {
    const wrapper = mount(StatCard, {
      props: {
        label: 'Presentes',
        value: '35 (85%)',
        icon: 'check',
        type: 'success',
      },
    });

    const card = wrapper.find('.bg-green-100');
    expect(card.exists()).toBe(true);
  });

  it('applies danger color when type is danger', () => {
    const wrapper = mount(StatCard, {
      props: {
        label: 'Ausentes',
        value: 5,
        icon: 'x',
        type: 'danger',
      },
    });

    const card = wrapper.find('.bg-red-100');
    expect(card.exists()).toBe(true);
  });

  it('renders correct icon based on icon prop', () => {
    const wrapper = mount(StatCard, {
      props: {
        label: 'Test',
        value: 10,
        icon: 'building',
        type: 'info',
      },
    });

    expect(wrapper.find('svg').exists()).toBe(true);
  });

  it('displays label and value correctly', () => {
    const testLabel = 'Carreras Técnicas';
    const testValue = 10;

    const wrapper = mount(StatCard, {
      props: {
        label: testLabel,
        value: testValue,
        icon: 'building',
        type: 'default',
      },
    });

    expect(wrapper.text()).toContain(testLabel);
    expect(wrapper.text()).toContain(testValue.toString());
  });
});
